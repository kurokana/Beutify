<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    private const SHIPPING_MAP = [
        'reguler' => 15000,
        'express' => 35000,
        'same_day' => 65000,
    ];

    public function index(): View|RedirectResponse
    {
        $user = auth()->user();
        $cartItems = array_values(session('cart', []));

        if (count($cartItems) === 0) {
            return redirect()->route('keranjang')->with('error', 'Keranjang masih kosong.');
        }

        $subtotal = collect($cartItems)->sum(fn (array $item) => $item['price'] * $item['qty']);
        $shipping = self::SHIPPING_MAP['reguler'];
        $tax = (int) round($subtotal * 0.1);
        $total = $subtotal + $shipping + $tax;
        $addresses = $user->addresses()->latest()->get();
        $defaultAddress = $addresses->firstWhere('is_default', true) ?? $addresses->first();

        return view('checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'addresses', 'defaultAddress'));
    }

    public function process(Request $request): RedirectResponse
    {
        $user = $request->user();
        $cartItems = array_values(session('cart', []));

        if (count($cartItems) === 0) {
            return redirect()->route('keranjang')->with('error', 'Keranjang masih kosong.');
        }

        $validated = $request->validate([
            'address_id' => 'nullable|integer',
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'shipping_method' => 'required|in:reguler,express,same_day',
            'payment_method' => 'required|in:bank_transfer,e_wallet,credit_card,cod',
            'notes' => 'nullable|string',
            'save_address' => 'nullable|boolean',
        ]);

        $selectedAddress = null;

        if (! empty($validated['address_id'])) {
            $selectedAddress = $user->addresses()->where('id', (int) $validated['address_id'])->first();

            if (! $selectedAddress) {
                return back()->withErrors(['address_id' => 'Alamat tidak valid untuk akun ini.'])->withInput();
            }

            $validated['recipient_name'] = $selectedAddress->recipient_name;
            $validated['phone_number'] = $selectedAddress->phone_number;
            $validated['address'] = $selectedAddress->address;
            $validated['city'] = $selectedAddress->city;
            $validated['postal_code'] = $selectedAddress->postal_code;
        }

        $subtotal = collect($cartItems)->sum(fn (array $item) => $item['price'] * $item['qty']);
        $shipping = self::SHIPPING_MAP[$validated['shipping_method']];
        $tax = (int) round($subtotal * 0.1);
        $total = $subtotal + $shipping + $tax;

        $shouldSaveAddress = (bool) ($validated['save_address'] ?? false);
        $addressId = $selectedAddress?->id;

        if ($shouldSaveAddress && ! $selectedAddress) {
            $existingAddress = $user->addresses()
                ->where('recipient_name', $validated['recipient_name'])
                ->where('phone_number', $validated['phone_number'])
                ->where('address', $validated['address'])
                ->where('city', $validated['city'])
                ->where('postal_code', $validated['postal_code'])
                ->first();

            if ($existingAddress) {
                $addressId = $existingAddress->id;
            } elseif ($user->addresses()->count() >= 5) {
                return back()->withErrors(['save_address' => 'Maksimal 5 alamat per akun.'])->withInput();
            } else {
                $address = $user->addresses()->create([
                    'recipient_name' => $validated['recipient_name'],
                    'phone_number' => $validated['phone_number'],
                    'address' => $validated['address'],
                    'city' => $validated['city'],
                    'postal_code' => $validated['postal_code'],
                    'is_default' => $user->addresses()->count() === 0,
                ]);

                $addressId = $address->id;
            }
        }

        $order = DB::transaction(function () use ($user, $validated, $addressId, $subtotal, $shipping, $tax, $total, $cartItems) {
            $order = $user->orders()->create([
                'address_id' => $addressId,
                'recipient_name' => $validated['recipient_name'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'shipping_method' => $validated['shipping_method'],
                'shipping_cost' => $shipping,
                'payment_method' => $validated['payment_method'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item['id'],
                    'name' => $item['name'],
                    'variant' => $item['variant'] ?? null,
                    'emoji' => $item['emoji'] ?? null,
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);
            }

            return $order;
        });

        session([
            'checkout_order_id' => $order->id,
            'cart' => [],
        ]);

        return redirect()->route('order.confirmation')->with('success', 'Pesanan berhasil diproses!');
    }

    public function confirmation(): View|RedirectResponse
    {
        $orderId = (int) session('checkout_order_id', 0);

        $order = Order::with('items')
            ->where('id', $orderId)
            ->where('user_id', auth()->id())
            ->first();

        if (! $order) {
            return redirect()->route('dashboard');
        }

        return view('order-confirmation', ['order' => $order]);
    }
}

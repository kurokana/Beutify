<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $cartItems = array_values(session('cart', []));

        if (count($cartItems) === 0) {
            return redirect()->route('keranjang')->with('error', 'Keranjang masih kosong.');
        }

        $subtotal = collect($cartItems)->sum(fn (array $item) => $item['price'] * $item['qty']);
        $shipping = self::SHIPPING_MAP['reguler'];
        $tax = (int) round($subtotal * 0.1);
        $total = $subtotal + $shipping + $tax;

        return view('checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function process(Request $request): RedirectResponse
    {
        $cartItems = array_values(session('cart', []));

        if (count($cartItems) === 0) {
            return redirect()->route('keranjang')->with('error', 'Keranjang masih kosong.');
        }

        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'shipping_method' => 'required|in:reguler,express,same_day',
            'payment_method' => 'required|in:bank_transfer,e_wallet,credit_card,cod',
            'notes' => 'nullable|string',
        ]);

        $subtotal = collect($cartItems)->sum(fn (array $item) => $item['price'] * $item['qty']);
        $shipping = self::SHIPPING_MAP[$validated['shipping_method']];
        $tax = (int) round($subtotal * 0.1);
        $total = $subtotal + $shipping + $tax;

        $order = [
            'customer' => $validated,
            'items' => $cartItems,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
            ],
        ];

        session([
            'checkout_data' => $order,
            'cart' => [],
        ]);

        return redirect()->route('order.confirmation')->with('success', 'Pesanan berhasil diproses!');
    }

    public function confirmation(): View|RedirectResponse
    {
        $order = session('checkout_data');

        if (! $order) {
            return redirect()->route('dashboard');
        }

        return view('order-confirmation', ['order' => $order]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Support\ProductCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = array_values(session('cart', []));
        $subtotal = collect($cartItems)->sum(fn (array $item) => $item['price'] * $item['qty']);
        $shipping = $subtotal > 0 ? 15000 : 0;
        $total = $subtotal + $shipping;

        return view('keranjang', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
            'qty' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = ProductCatalog::find((int) $validated['product_id']);

        if (! $product) {
            abort(404);
        }

        $qty = (int) ($validated['qty'] ?? 1);
        $cart = session('cart', []);
        $productId = (int) $product['id'];

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $qty;
        } else {
            $cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'variant' => $product['variant'],
                'price' => $product['price'],
                'qty' => $qty,
                'emoji' => $product['emoji'],
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', $product['name'].' ditambahkan ke keranjang.');
    }

    public function update(Request $request, int $productId): RedirectResponse
    {
        $validated = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session('cart', []);

        if (! isset($cart[$productId])) {
            return redirect()->route('keranjang');
        }

        $cart[$productId]['qty'] = (int) $validated['qty'];
        session(['cart' => $cart]);

        return back()->with('success', 'Jumlah produk diperbarui.');
    }

    public function remove(int $productId): RedirectResponse
    {
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}

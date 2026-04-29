<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - BEUTIFY</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">

    <header class="w-full bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <x-application-logo class="h-16 w-auto" />
            </a>

            <form action="{{ route('search') }}" method="GET" class="flex-1 mx-12">
                <div class="border-2 border-black flex items-center px-5 py-3 bg-white">
                    <input
                        type="text"
                        name="q"
                        placeholder="Cari skincare..."
                        class="w-full outline-none bg-transparent text-gray-500 text-base"
                    >
                    <button type="submit" class="text-2xl">🔍</button>
                </div>
            </form>

            <div class="flex items-center gap-6">
                <a href="{{ route('keranjang') }}" class="text-3xl hover:text-pink-500 transition">🛒</a>
                <a href="{{ route('profile.edit') }}">
                    <div class="w-11 h-11 rounded-full bg-gray-200 flex items-center justify-center text-2xl hover:bg-pink-100 transition">👤</div>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('keranjang') }}"
               class="flex items-center justify-center w-10 h-10 rounded-full border hover:bg-pink-100 hover:text-pink-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-4xl font-bold">Checkout</h1>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" class="grid lg:grid-cols-3 gap-8">
            @csrf

            <section class="lg:col-span-2 space-y-6">
                <div class="bg-white border rounded-2xl p-6 shadow-sm">
                    <h2 class="text-2xl font-bold mb-5">Alamat Pengiriman</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Nama Penerima</label>
                            <input type="text" name="recipient_name" value="{{ old('recipient_name') }}" required class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500">
                            @error('recipient_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Nomor Telepon</label>
                            <input type="tel" name="phone_number" value="{{ old('phone_number') }}" required class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500">
                            @error('phone_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Alamat Lengkap</label>
                            <textarea name="address" rows="4" required class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500">{{ old('address') }}</textarea>
                            @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Kota/Kabupaten</label>
                                <input type="text" name="city" value="{{ old('city') }}" required class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500">
                                @error('city')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Kode Pos</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code') }}" required class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500">
                                @error('postal_code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border rounded-2xl p-6 shadow-sm">
                    <h2 class="text-2xl font-bold mb-5">Metode Pengiriman</h2>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="shipping_method" value="reguler" {{ old('shipping_method', 'reguler') === 'reguler' ? 'checked' : '' }} class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold">Reguler (3-5 hari) - Rp 15.000</p>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="shipping_method" value="express" {{ old('shipping_method') === 'express' ? 'checked' : '' }} class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold">Express (1-2 hari) - Rp 35.000</p>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="shipping_method" value="same_day" {{ old('shipping_method') === 'same_day' ? 'checked' : '' }} class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold">Same Day (Hari Sama) - Rp 65.000</p>
                            </div>
                        </label>
                        @error('shipping_method')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="bg-white border rounded-2xl p-6 shadow-sm">
                    <h2 class="text-2xl font-bold mb-5">Metode Pembayaran</h2>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method', 'bank_transfer') === 'bank_transfer' ? 'checked' : '' }} class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1"><p class="font-semibold">Transfer Bank</p></div>
                        </label>
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="payment_method" value="e_wallet" {{ old('payment_method') === 'e_wallet' ? 'checked' : '' }} class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1"><p class="font-semibold">E-Wallet</p></div>
                        </label>
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="payment_method" value="credit_card" {{ old('payment_method') === 'credit_card' ? 'checked' : '' }} class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1"><p class="font-semibold">Kartu Kredit/Debit</p></div>
                        </label>
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="payment_method" value="cod" {{ old('payment_method') === 'cod' ? 'checked' : '' }} class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1"><p class="font-semibold">Cash on Delivery (COD)</p></div>
                        </label>
                        @error('payment_method')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="bg-white border rounded-2xl p-6 shadow-sm">
                    <h2 class="text-2xl font-bold mb-5">Catatan Pesanan (Opsional)</h2>
                    <textarea name="notes" rows="3" class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500">{{ old('notes') }}</textarea>
                </div>
            </section>

            <aside class="bg-white border rounded-2xl p-6 shadow-sm h-fit sticky top-24" data-subtotal="{{ $subtotal }}" data-tax="{{ $tax }}">
                <h2 class="text-2xl font-bold mb-5">Ringkasan Pesanan</h2>

                <div class="mb-5 pb-5 border-b space-y-3">
                    @foreach ($cartItems as $item)
                        <div class="flex justify-between gap-3 text-sm">
                            <span>{{ $item['emoji'] }} {{ $item['name'] }} x{{ $item['qty'] }}</span>
                            <span>Rp {{ number_format($item['qty'] * $item['price'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-3 text-gray-700 mb-5 pb-5 border-b">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pajak (10%)</span>
                        <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Ongkir (default)</span>
                        <span id="shippingDisplay">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="flex justify-between text-2xl font-bold mb-6">
                    <span>Total</span>
                    <span class="text-pink-500" id="totalDisplay">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <button type="submit" class="w-full bg-pink-500 text-white py-3 rounded-lg font-semibold hover:bg-pink-600 transition">
                    Konfirmasi Pesanan
                </button>

                <a href="{{ route('keranjang') }}" class="block text-center mt-4 text-gray-600 font-semibold hover:text-pink-500 transition">
                    Kembali ke Keranjang
                </a>
            </aside>
        </form>

    </main>

</body>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const shippingMap = {
        reguler: 15000,
        express: 35000,
        same_day: 65000,
    };

    const summaryCard = document.querySelector('aside[data-subtotal]');

    if (!summaryCard) {
        return;
    }

    const subtotal = Number(summaryCard.dataset.subtotal || 0);
    const tax = Number(summaryCard.dataset.tax || 0);
    const shippingDisplay = document.getElementById('shippingDisplay');
    const totalDisplay = document.getElementById('totalDisplay');

    function formatCurrency(value) {
        return 'Rp ' + value.toLocaleString('id-ID');
    }

    function updateSummary() {
        const selected = document.querySelector('input[name="shipping_method"]:checked');
        const shipping = shippingMap[selected ? selected.value : 'reguler'] || shippingMap.reguler;
        const total = subtotal + tax + shipping;

        shippingDisplay.textContent = formatCurrency(shipping);
        totalDisplay.textContent = formatCurrency(total);
    }

    document.querySelectorAll('input[name="shipping_method"]').forEach(function (radio) {
        radio.addEventListener('change', updateSummary);
    });

    updateSummary();
});
</script>
</html>

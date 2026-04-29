<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - BEUTIFY</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">

    {{-- HEADER --}}
    <header class="w-full bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- LOGO --}}
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <x-application-logo class="h-16 w-auto" />
            </a>

            {{-- SEARCH BAR --}}
            <div class="flex-1 mx-12">
                <div class="border-2 border-black flex items-center px-5 py-3 bg-white">
                    <input
                        type="text"
                        placeholder="Cari skincare..."
                        class="w-full outline-none bg-transparent text-gray-500 text-base"
                    >
                    <span class="text-2xl">🔍</span>
                </div>
            </div>

            {{-- CART + PROFILE --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('keranjang') }}" class="text-3xl hover:text-pink-500 transition">
                    🛒
                </a>

                <a href="{{ route('profile.edit') }}">
                    <div class="w-11 h-11 rounded-full bg-gray-200 flex items-center justify-center text-2xl hover:bg-pink-100 transition">
                        👤
                    </div>
                </a>
            </div>

        </div>
    </header>

    {{-- CHECKOUT --}}
    <main class="max-w-7xl mx-auto px-6 py-10">

        {{-- BACK + TITLE --}}
        <div class="flex items-center gap-4 mb-8">

            {{-- BACK ICON --}}
            <a href="{{ route('keranjang') }}" 
               class="flex items-center justify-center w-10 h-10 rounded-full border hover:bg-pink-100 hover:text-pink-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="w-5 h-5" 
                     fill="none" 
                     viewBox="0 0 24 24" 
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            {{-- TITLE --}}
            <h1 class="text-4xl font-bold">Checkout</h1>

        </div>

        @php
            $cartItems = [
                [
                    'name' => 'Hydrating Serum',
                    'variant' => 'Serum wajah untuk kulit lembap',
                    'price' => 89000,
                    'qty' => 1,
                    'emoji' => '🧴'
                ],
                [
                    'name' => 'Daily Sunscreen SPF 50',
                    'variant' => 'Sunscreen ringan untuk harian',
                    'price' => 99000,
                    'qty' => 2,
                    'emoji' => '☀️'
                ],
                [
                    'name' => 'Gentle Facial Wash',
                    'variant' => 'Pembersih wajah lembut',
                    'price' => 55000,
                    'qty' => 1,
                    'emoji' => '🫧'
                ],
            ];

            $subtotal = collect($cartItems)->sum(fn($item) => $item['price'] * $item['qty']);
            $shipping = 15000;
            $tax = round($subtotal * 0.1);
            $total = $subtotal + $shipping + $tax;
        @endphp

        <form action="{{ route('checkout.process') }}" method="POST" class="grid lg:grid-cols-3 gap-8">
            @csrf

            {{-- FORM SECTION --}}
            <section class="lg:col-span-2 space-y-6">

                {{-- ALAMAT PENGIRIMAN --}}
                <div class="bg-white border rounded-2xl p-6 shadow-sm">
                    <h2 class="text-2xl font-bold mb-5">📍 Alamat Pengiriman</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Nama Penerima</label>
                            <input 
                                type="text" 
                                name="recipient_name"
                                placeholder="Masukkan nama penerima"
                                required
                                class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Nomor Telepon</label>
                            <input 
                                type="tel" 
                                name="phone_number"
                                placeholder="Masukkan nomor telepon"
                                required
                                class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Alamat Lengkap</label>
                            <textarea 
                                name="address"
                                placeholder="Jl. ..., No. ..., Kota, Provinsi"
                                rows="4"
                                required
                                class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500"
                            ></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Kota/Kabupaten</label>
                                <input 
                                    type="text" 
                                    name="city"
                                    placeholder="Kota"
                                    required
                                    class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500"
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Kode Pos</label>
                                <input 
                                    type="text" 
                                    name="postal_code"
                                    placeholder="12345"
                                    required
                                    class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                {{-- METODE PENGIRIMAN --}}
                <div class="bg-white border rounded-2xl p-6 shadow-sm">
                    <h2 class="text-2xl font-bold mb-5">🚚 Metode Pengiriman</h2>

                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="shipping_method" value="reguler" checked class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold">Reguler (3-5 hari) - Rp 15.000</p>
                                <p class="text-sm text-gray-500">Pengiriman standar</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="shipping_method" value="express" class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold">Express (1-2 hari) - Rp 35.000</p>
                                <p class="text-sm text-gray-500">Pengiriman cepat</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="shipping_method" value="same_day" class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold">Same Day (Hari Sama) - Rp 65.000</p>
                                <p class="text-sm text-gray-500">Pengiriman hari yang sama (khusus area Jakarta)</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- METODE PEMBAYARAN --}}
                <div class="bg-white border rounded-2xl p-6 shadow-sm">
                    <h2 class="text-2xl font-bold mb-5">💳 Metode Pembayaran</h2>

                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="payment_method" value="bank_transfer" checked class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold">💰 Transfer Bank</p>
                                <p class="text-sm text-gray-500">Transfer ke rekening BEUTIFY</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="payment_method" value="e_wallet" class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold">📱 E-Wallet (GCash, OVO, DANA)</p>
                                <p class="text-sm text-gray-500">Pembayaran melalui dompet digital</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="payment_method" value="credit_card" class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold">🏧 Kartu Kredit/Debit</p>
                                <p class="text-sm text-gray-500">Pembayaran dengan kartu bank</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-pink-50 transition">
                            <input type="radio" name="payment_method" value="cod" class="w-5 h-5 text-pink-500">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold">🚚 Cash on Delivery (COD)</p>
                                <p class="text-sm text-gray-500">Bayar saat barang tiba</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- CATATAN PESANAN --}}
                <div class="bg-white border rounded-2xl p-6 shadow-sm">
                    <h2 class="text-2xl font-bold mb-5">📝 Catatan Pesanan (Opsional)</h2>

                    <textarea 
                        name="notes"
                        placeholder="Tambahkan catatan untuk penjual (misalnya: jangan gunakan bubble wrap, dll)"
                        rows="3"
                        class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-pink-500"
                    ></textarea>
                </div>

            </section>

            {{-- RINGKASAN PESANAN --}}
            <aside class="bg-white border rounded-2xl p-6 shadow-sm h-fit sticky top-24">
                <h2 class="text-2xl font-bold mb-5">📦 Ringkasan Pesanan</h2>

                {{-- PRODUK --}}
                <div class="mb-5 pb-5 border-b space-y-3">
                    @foreach ($cartItems as $item)
                        <div class="flex justify-between text-sm">
                            <span>{{ $item['name'] }} (x{{ $item['qty'] }})</span>
                            <span class="font-semibold">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- DETAIL BIAYA --}}
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
                        <span>Ongkir</span>
                        <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- TOTAL --}}
                <div class="flex justify-between text-2xl font-bold mb-6">
                    <span>Total</span>
                    <span class="text-pink-500">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                {{-- BUTTON --}}
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
</html>

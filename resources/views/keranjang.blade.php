<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang - BEUTIFY</title>

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

            {{-- CART + PROFILE --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('keranjang') }}" class="text-3xl text-pink-500 transition">
                    🛒
                </a>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">
                            <div class="w-11 h-11 rounded-full bg-gray-200 flex items-center justify-center text-2xl hover:bg-pink-100 transition">
                                👤
                            </div>
                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            <div class="w-11 h-11 rounded-full bg-gray-200 flex items-center justify-center text-2xl hover:bg-pink-100 transition">
                                👤
                            </div>
                        </a>
                    @endauth
                @endif
            </div>

        </div>
    </header>

    {{-- KERANJANG --}}
    <main class="max-w-7xl mx-auto px-6 py-10">

        {{-- BACK + TITLE --}}
        <div class="flex items-center gap-4 mb-8">

            {{-- BACK ICON --}}
            <a href="{{ route('dashboard') }}" 
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
            <h1 class="text-4xl font-bold">Keranjang Belanja</h1>

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
            $total = $subtotal + $shipping;
        @endphp

        <div class="grid lg:grid-cols-3 gap-8">

            {{-- LIST PRODUK --}}
            <section class="lg:col-span-2 space-y-5">
                @foreach ($cartItems as $item)
                    <div class="bg-white border rounded-2xl p-5 flex gap-5 items-center shadow-sm">

                        <div class="w-28 h-28 bg-pink-50 rounded-xl flex items-center justify-center text-5xl">
                            {{ $item['emoji'] }}
                        </div>

                        <div class="flex-1">
                            <h2 class="text-xl font-bold">{{ $item['name'] }}</h2>
                            <p class="text-gray-500 mt-1">{{ $item['variant'] }}</p>
                            <p class="text-pink-600 font-bold mt-3">
                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="w-9 h-9 border rounded-full text-lg hover:bg-gray-100">-</button>
                            <span class="font-semibold">{{ $item['qty'] }}</span>
                            <button class="w-9 h-9 border rounded-full text-lg hover:bg-gray-100">+</button>
                        </div>

                        <button class="text-red-500 font-semibold hover:underline">
                            Hapus
                        </button>

                    </div>
                @endforeach
            </section>

            {{-- RINGKASAN --}}
            <aside class="bg-white border rounded-2xl p-6 shadow-sm h-fit">
                <h2 class="text-2xl font-bold mb-5">Ringkasan Belanja</h2>

                <div class="space-y-3 text-gray-700">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Ongkir</span>
                        <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>

                    <hr class="my-4">

                    <div class="flex justify-between text-xl font-bold">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout') }}" class="block w-full mt-6 bg-pink-500 text-white py-3 rounded-lg font-semibold hover:bg-pink-600 transition text-center">
                    Checkout
                </a>

                <a href="{{ route('dashboard') }}" class="block text-center mt-4 text-pink-600 font-semibold hover:underline">
                    Lanjut Belanja
                </a>
            </aside>

        </div>
    </main>

</body>
</html>
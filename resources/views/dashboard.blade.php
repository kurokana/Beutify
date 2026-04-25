<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BEUTIFY - Skincare Store</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">

    {{-- HEADER --}}
    <header class="w-full bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- LOGO --}}
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="h-16 w-auto" />
            </a>

            {{-- SEARCH (SUDAH BERFUNGSI) --}}
            <form action="{{ route('search') }}" method="GET" class="flex-1 mx-12">
                <div class="border-2 border-black flex items-center px-5 py-3">

                    <input 
                        type="text" 
                        name="q"
                        required
                        placeholder="Cari skincare..."
                        class="w-full outline-none bg-transparent text-gray-500"
                    >

                    <button type="submit" class="text-2xl">
                        🔍
                    </button>

                </div>
            </form>

            {{-- CART + PROFILE --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('keranjang') }}" class="text-3xl hover:text-pink-500">🛒</a>

                <a href="{{ route('profile.edit') }}">
                    <div class="w-11 h-11 rounded-full bg-gray-200 flex items-center justify-center text-2xl hover:bg-pink-100">
                        👤
                    </div>
                </a>
            </div>

        </div>
    </header>

    {{-- BRAND --}}
    <section class="bg-gradient-to-r from-pink-50 to-purple-50 py-12">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-6">
                <h2 class="text-3xl font-bold">Brand Skincare Terlaris</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach (['Skintific','Somethinc','Avoskin','Wardah','Azarine','Scarlett','Emina','Originote','Hanasui','MS Glow'] as $brand)
                    <div class="bg-white p-6 rounded-xl shadow-sm text-center font-bold">
                        {{ $brand }}
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- HERO --}}
    <section class="py-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-pink-100 rounded-2xl grid md:grid-cols-2 items-center">

                <div class="p-12">
                    <p class="text-pink-600 font-semibold mb-3">NEW ARRIVAL</p>
                    <h2 class="text-5xl font-bold mb-4">Glow Skin, Happy You</h2>
                    <p class="text-gray-700 mb-6">
                        Temukan skincare terbaik untuk kulit sehat & glowing.
                    </p>
                    <button class="bg-pink-500 text-white px-8 py-3 rounded-lg hover:bg-pink-600">
                        Shop Now
                    </button>
                </div>

                <div class="bg-pink-200 flex justify-center items-center text-7xl">
                    🧴✨
                </div>

            </div>
        </div>
    </section>

    {{-- PRODUK --}}
    <section class="py-10">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold mb-6">Rekomendasi Produk</h2>

            @php
                $products = [
                    ['id'=>1,'name'=>'Hydrating Serum','price'=>'Rp 89.000','emoji'=>'🧴'],
                    ['id'=>2,'name'=>'Toner','price'=>'Rp 75.000','emoji'=>'💧'],
                    ['id'=>3,'name'=>'Sunscreen','price'=>'Rp 99.000','emoji'=>'☀️'],
                    ['id'=>4,'name'=>'Facial Wash','price'=>'Rp 55.000','emoji'=>'🫧'],
                ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($products as $p)
                    <div class="bg-white border rounded-2xl shadow-sm">

                        <div class="bg-pink-50 h-44 flex items-center justify-center text-5xl">
                            {{ $p['emoji'] }}
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold">{{ $p['name'] }}</h3>
                            <p class="text-pink-600 font-bold mb-3">{{ $p['price'] }}</p>

                            {{-- DETAIL PRODUK --}}
                            <a href="{{ route('product', $p['id']) }}"
                               class="block text-center border border-pink-500 text-pink-500 py-2 rounded-lg mb-2 hover:bg-pink-50">
                                Lihat Detail
                            </a>

                            <button class="w-full bg-pink-500 text-white py-2 rounded-lg">
                                Tambah ke Keranjang
                            </button>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- KEUNTUNGAN --}}
    <section class="py-14 bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold text-center mb-10">
                Keuntungan Belanja di BEUTIFY
            </h2>

            <div class="grid md:grid-cols-4 gap-8 text-center">

                <div>
                    <div class="text-4xl mb-3">✅</div>
                    <h3 class="font-bold">Original Product</h3>
                    <p class="text-gray-600 text-sm">
                        Produk 100% original & terpercaya
                    </p>
                </div>

                <div>
                    <div class="text-4xl mb-3">💸</div>
                    <h3 class="font-bold">Best Price</h3>
                    <p class="text-gray-600 text-sm">
                        Harga terbaik setiap hari
                    </p>
                </div>

                <div>
                    <div class="text-4xl mb-3">🚚</div>
                    <h3 class="font-bold">Fast Delivery</h3>
                    <p class="text-gray-600 text-sm">
                        Pengiriman cepat & aman
                    </p>
                </div>

                <div>
                    <div class="text-4xl mb-3">🎁</div>
                    <h3 class="font-bold">Extra Benefit</h3>
                    <p class="text-gray-600 text-sm">
                        Promo & bonus menarik
                    </p>
                </div>

            </div>

        </div>
    </section>

</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product['name'] }} - BEUTIFY</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">

    <header class="w-full bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <a href="{{ route('dashboard') }}">
                <x-application-logo class="h-16 w-auto" />
            </a>

            <form action="{{ route('search') }}" method="GET" class="flex-1 mx-12">
                <div class="border-2 border-black flex items-center px-5 py-3">
                    <input
                        type="text"
                        name="q"
                        placeholder="Cari skincare..."
                        class="w-full outline-none bg-transparent text-gray-500"
                    >
                    <button type="submit" class="text-2xl">🔍</button>
                </div>
            </form>

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

    <main class="max-w-7xl mx-auto px-6 py-10">

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ url()->previous() }}"
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

            <h1 class="text-4xl font-bold">Detail Produk</h1>
        </div>

        <section class="bg-white border rounded-2xl shadow-sm overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8">

                <div class="bg-pink-50 flex items-center justify-center text-9xl min-h-[420px]">
                    {{ $product['emoji'] }}
                </div>

                <div class="p-8">
                    <p class="text-pink-600 font-semibold mb-2">{{ $product['brand'] }}</p>

                    <h2 class="text-4xl font-bold mb-3">
                        {{ $product['name'] }}
                    </h2>

                    <p class="text-2xl text-pink-600 font-bold mb-6">
                        Rp {{ number_format($product['price'], 0, ',', '.') }}
                    </p>

                    <p class="text-gray-600 leading-relaxed mb-6">
                        {{ $product['desc'] }}
                    </p>

                    <div class="space-y-3 mb-8">
                        <div class="flex justify-between border-b pb-2">
                            <span class="font-semibold">Kategori</span>
                            <span>{{ $product['category'] }}</span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="font-semibold">Cocok untuk</span>
                            <span>{{ $product['skin'] }}</span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="font-semibold">Ukuran</span>
                            <span>{{ $product['size'] }}</span>
                        </div>

                        <div class="border-b pb-2">
                            <span class="font-semibold block mb-1">Kandungan</span>
                            <span class="text-gray-600">{{ $product['ingredients'] }}</span>
                        </div>
                    </div>

                    <button class="w-full bg-pink-500 text-white py-3 rounded-lg font-semibold hover:bg-pink-600">
                        Tambah ke Keranjang
                    </button>
                </div>

            </div>
        </section>

    </main>

</body>
</html>
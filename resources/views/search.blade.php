<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Pencarian - BEUTIFY</title>

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
                        value="{{ $query }}"
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

            <div>
                <h1 class="text-4xl font-bold">Hasil Pencarian</h1>
                <p class="text-gray-500 mt-1">
                    Menampilkan hasil untuk: "{{ $query }}"
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse ($results as $product)
                <a href="{{ route('product', $product['id']) }}"
                   class="bg-white border rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition">

                    <div class="bg-pink-50 h-44 flex items-center justify-center text-5xl">
                        {{ $product['emoji'] }}
                    </div>

                    <div class="p-4">
                        <p class="text-sm text-gray-500">{{ $product['brand'] }}</p>
                        <h2 class="font-semibold text-lg">{{ $product['name'] }}</h2>
                        <p class="text-gray-500 text-sm mb-3">{{ $product['category'] }}</p>

                        <p class="text-pink-600 font-bold">
                            Rp {{ number_format($product['price'], 0, ',', '.') }}
                        </p>
                    </div>

                </a>
            @empty
                <div class="col-span-4 bg-white border rounded-2xl p-10 text-center">
                    <div class="text-6xl mb-4">🔍</div>

                    <h2 class="text-2xl font-bold mb-2">Produk tidak ditemukan</h2>

                    <p class="text-gray-500 mb-6">
                        Coba gunakan kata kunci lain seperti serum, toner, sunscreen, atau facial wash.
                    </p>

                    <a href="{{ route('dashboard') }}"
                       class="inline-block bg-pink-500 text-white px-6 py-3 rounded-lg hover:bg-pink-600">
                        Kembali ke Dashboard
                    </a>
                </div>
            @endforelse
        </div>

    </main>

</body>
</html>
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

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

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

        <div class="grid lg:grid-cols-3 gap-8">

            {{-- LIST PRODUK --}}
            <section class="lg:col-span-2 space-y-5">
                @forelse ($cartItems as $item)
                    <div class="bg-white border rounded-2xl p-5 flex gap-5 items-center shadow-sm">
                        <div class="w-24 h-24 bg-pink-50 rounded-xl flex items-center justify-center text-4xl">
                            {{ $item['emoji'] }}
                        </div>

                        <div class="flex-1">
                            <h2 class="text-xl font-bold">{{ $item['name'] }}</h2>
                            <p class="text-gray-500 mt-1">{{ $item['variant'] }}</p>
                            <p class="text-pink-600 font-bold mt-3">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>

                        <form action="{{ route('keranjang.update', $item['id']) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input
                                type="number"
                                name="qty"
                                min="1"
                                value="{{ $item['qty'] }}"
                                class="w-16 border rounded-lg px-2 py-1 text-center"
                            >
                            <button type="submit" class="px-3 py-1 border rounded-lg hover:bg-gray-100 transition">
                                Update
                            </button>
                        </form>

                        <form action="{{ route('keranjang.remove', $item['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 font-semibold hover:underline">
                                Hapus
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="bg-white border rounded-2xl p-10 text-center shadow-sm">
                        <div class="text-5xl mb-3">🛒</div>
                        <h2 class="text-2xl font-bold mb-2">Keranjang masih kosong</h2>
                        <p class="text-gray-500">Yuk pilih produk dulu untuk melanjutkan checkout.</p>
                    </div>
                @endforelse
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

                @if (count($cartItems) > 0)
                    <a href="{{ route('checkout') }}" class="block w-full mt-6 bg-pink-500 text-white py-3 rounded-lg font-semibold hover:bg-pink-600 transition text-center">
                        Checkout
                    </a>
                @else
                    <button type="button" class="block w-full mt-6 bg-gray-300 text-gray-600 py-3 rounded-lg font-semibold text-center cursor-not-allowed" disabled>
                        Checkout
                    </button>
                @endif

                <a href="{{ route('dashboard') }}" class="block text-center mt-4 text-pink-600 font-semibold hover:underline">
                    Lanjut Belanja
                </a>
            </aside>

        </div>
    </main>

</body>
</html>
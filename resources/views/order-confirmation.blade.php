<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Pesanan - BEUTIFY</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    <main class="max-w-3xl mx-auto px-6 py-12">
        <div class="bg-white border rounded-2xl p-8 shadow-sm">
            <h1 class="text-3xl font-bold mb-2">Pesanan Berhasil Dibuat</h1>
            <p class="text-gray-600 mb-8">Terima kasih sudah berbelanja di BEUTIFY.</p>

            <div class="space-y-3 border-b pb-5 mb-5">
                <div class="flex justify-between">
                    <span>Nama Penerima</span>
                    <span class="font-semibold">{{ $order['customer']['recipient_name'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Kota</span>
                    <span class="font-semibold">{{ $order['customer']['city'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order['summary']['subtotal'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Pajak</span>
                    <span>Rp {{ number_format($order['summary']['tax'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Ongkir</span>
                    <span>Rp {{ number_format($order['summary']['shipping'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xl font-bold">
                    <span>Total</span>
                    <span>Rp {{ number_format($order['summary']['total'], 0, ',', '.') }}</span>
                </div>
            </div>

            <a href="{{ route('dashboard') }}" class="inline-block bg-pink-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-pink-600 transition">
                Kembali ke Dashboard
            </a>
        </div>
    </main>
</body>
</html>

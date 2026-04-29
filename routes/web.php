<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/keranjang', function () {
    return view('keranjang');
})->middleware(['auth', 'verified'])->name('keranjang');

Route::get('/checkout', function () {
    return view('checkout');
})->middleware(['auth', 'verified'])->name('checkout');

Route::post('/checkout', function (Request $request) {
    // Validasi input
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

    // Simpan order (untuk sementara ke session, nanti bisa disimpan ke database)
    session(['checkout_data' => $validated]);

    // Redirect ke halaman konfirmasi atau pembayaran
    return redirect()->route('order.confirmation')->with('success', 'Pesanan berhasil diproses! Silakan lanjutkan dengan pembayaran.');
})->middleware(['auth', 'verified'])->name('checkout.process');

Route::get('/search', function (Request $request) {
    $query = strtolower($request->q ?? '');

    $products = collect([
        ['id'=>1, 'name'=>'Hydrating Serum', 'brand'=>'Somethinc', 'price'=>89000, 'emoji'=>'🧴', 'category'=>'Serum', 'desc'=>'Serum untuk melembapkan kulit.'],
        ['id'=>2, 'name'=>'Toner', 'brand'=>'Avoskin', 'price'=>75000, 'emoji'=>'💧', 'category'=>'Toner', 'desc'=>'Toner untuk membantu mencerahkan wajah.'],
        ['id'=>3, 'name'=>'Sunscreen', 'brand'=>'Azarine', 'price'=>99000, 'emoji'=>'☀️', 'category'=>'Sunscreen', 'desc'=>'Melindungi kulit dari sinar UV.'],
        ['id'=>4, 'name'=>'Facial Wash', 'brand'=>'Wardah', 'price'=>55000, 'emoji'=>'🫧', 'category'=>'Cleanser', 'desc'=>'Pembersih wajah lembut.'],
    ]);

    $results = $products->filter(function ($product) use ($query) {
        return str_contains(strtolower($product['name']), $query)
            || str_contains(strtolower($product['brand']), $query)
            || str_contains(strtolower($product['category']), $query);
    });

    return view('search', compact('results', 'query'));
})->middleware(['auth', 'verified'])->name('search');

Route::get('/product/{id}', function ($id) {
    $products = [
        1 => [
            'id'=>1,
            'name'=>'Hydrating Serum',
            'brand'=>'Somethinc',
            'price'=>89000,
            'emoji'=>'🧴',
            'category'=>'Serum',
            'skin'=>'Kulit kering dan normal',
            'size'=>'30 ml',
            'ingredients'=>'Hyaluronic Acid, Ceramide, Aloe Vera',
            'desc'=>'Hydrating Serum membantu menjaga kelembapan kulit, memperkuat skin barrier, dan membuat kulit tampak lebih sehat.'
        ],
        2 => [
            'id'=>2,
            'name'=>'Toner',
            'brand'=>'Avoskin',
            'price'=>75000,
            'emoji'=>'💧',
            'category'=>'Toner',
            'skin'=>'Kulit kusam',
            'size'=>'100 ml',
            'ingredients'=>'Niacinamide, Licorice Extract, Green Tea',
            'desc'=>'Toner membantu menyegarkan kulit dan membuat wajah tampak lebih cerah.'
        ],
        3 => [
            'id'=>3,
            'name'=>'Sunscreen',
            'brand'=>'Azarine',
            'price'=>99000,
            'emoji'=>'☀️',
            'category'=>'Sunscreen',
            'skin'=>'Semua jenis kulit',
            'size'=>'50 ml',
            'ingredients'=>'UV Filter, Centella Asiatica, Vitamin E',
            'desc'=>'Sunscreen melindungi kulit dari paparan sinar UVA dan UVB.'
        ],
        4 => [
            'id'=>4,
            'name'=>'Facial Wash',
            'brand'=>'Wardah',
            'price'=>55000,
            'emoji'=>'🫧',
            'category'=>'Cleanser',
            'skin'=>'Kulit berminyak dan kombinasi',
            'size'=>'100 ml',
            'ingredients'=>'Tea Tree, Gentle Foam, Chamomile',
            'desc'=>'Facial Wash membersihkan wajah dari minyak, debu, dan kotoran tanpa membuat kulit terasa kering.'
        ],
    ];

    abort_if(!isset($products[$id]), 404);

    return view('product', [
        'product' => $products[$id]
    ]);
})->middleware(['auth', 'verified'])->name('product');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
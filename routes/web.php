<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Support\ProductCatalog;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::post('/keranjang', [CartController::class, 'add'])->name('keranjang.add');
    Route::patch('/keranjang/{productId}', [CartController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{productId}', [CartController::class, 'remove'])->name('keranjang.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/confirmation', [CheckoutController::class, 'confirmation'])->name('order.confirmation');
});

Route::get('/search', function (Request $request) {
    $query = strtolower($request->q ?? '');

    $results = ProductCatalog::search($query);

    return view('search', compact('results', 'query'));
})->middleware(['auth', 'verified'])->name('search');

Route::get('/product/{id}', function ($id) {
    $product = ProductCatalog::find((int) $id);
    abort_if(! $product, 404);

    return view('product', [
        'product' => $product,
    ]);
})->middleware(['auth', 'verified'])->name('product');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
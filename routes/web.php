<?php

use App\Domain\Order\Controllers\OrderController;
use App\Domain\Product\Controllers\ProductController;
use App\Domain\Root\Controllers\RootController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RootController::class, 'index'])->name('home.index');
Route::get('/product/{category}/{games}', [ProductController::class, 'index'])->name('product.index');
Route::get('/search', [RootController::class, 'search'])->name('home.search');

Route::post('/check-user', [ProductController::class, 'checkUsername'])->name('check.user');
Route::post('/check-voucher', [ProductController::class, 'checkUsername'])->name('voucher.check');
Route::post('/order', [OrderController::class, 'createTokenMidtrans'])->name('order.createTokenMidtrans');
Route::get('/sync', [ProductController::class, 'syncProductDigiflazz'])->name('sync.product');

Route::get('/list-harga', [RootController::class, 'listHarga'])->name('listHarga');
Route::get('/cek-pesanan', [RootController::class, 'cekPesanan'])->name('cekPesanan');


// require __DIR__ . '/settings.php';

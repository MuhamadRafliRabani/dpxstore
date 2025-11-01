<?php

use App\Domain\Order\Controllers\OrderController;
use App\Domain\Product\Controllers\ProductController;
use App\Domain\Root\Controllers\RootController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RootController::class, 'index'])->name('home.index');
Route::get('/products', [RootController::class, 'getDataProducts'])->name('home.getDataProducts');
Route::get('/product/{category}/{games}', [ProductController::class, 'index'])->name('product.index');
Route::get('/search', [RootController::class, 'search'])->name('home.search');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');

Route::post('/check-user', [ProductController::class, 'checkUsername'])->name('check.user');
Route::post('/check-voucher', [ProductController::class, 'checkUsername'])->name('voucher.check');
Route::get('/sync', [ProductController::class, 'syncProductDigiflazz'])->name('sync.product');

Route::get('/list-harga', [RootController::class, 'listHarga'])->name('listHarga');
Route::get('/cek-pesanan', [OrderController::class, 'cekPesanan'])->name('cekPesanan');
Route::post('/getOrder', [OrderController::class, 'getOrder'])->name('getOrder');

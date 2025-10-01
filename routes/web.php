<?php

use App\Domain\Order\Controllers\OrderController;
use App\Domain\Product\Controllers\ProductController;
use App\Domain\Products\Models\products;
use App\Domain\Root\Controllers\RootController;
use App\Domain\Voucher\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [RootController::class, 'index'])->name('home.index');
Route::get('/product/{category}/{games}', [ProductController::class, 'GetProductByGame'])->name('product.index');
Route::get('/search', [RootController::class, 'search'])->name('home.search');

Route::post('/check-user', [products::class, 'checkUsername'])->name('check.user');
Route::post('/check-voucher', [VoucherController::class, 'check'])->name('voucher.check');
Route::post('/order', [OrderController::class, 'createTransaction'])->name('order.createTransaction');

Route::get('/list-harga', [RootController::class, 'listHarga'])->name('listHarga');
Route::get('/cek-pesanan', [RootController::class, 'cekPesanan'])->name('cekPesanan');


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

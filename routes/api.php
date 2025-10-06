<?php

use App\Domain\Order\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/notification', [OrderController::class, 'handleNotification'])->name('order.handleNotification');

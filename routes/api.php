<?php

use App\Domain\Order\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/midtrans/notification', [OrderController::class, 'handleNotification']);

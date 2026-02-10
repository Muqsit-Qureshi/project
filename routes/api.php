<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CheckoutApiController;

Route::get('/products', [ProductApiController::class, 'index']);
Route::post('/cart/add', [CartApiController::class, 'addToCart']);
Route::get('/cart', [CartApiController::class, 'cartList']);
Route::post('/cart/update', [CartApiController::class, 'updateCartItem']);
Route::post('/cart/delete', [CartApiController::class, 'deleteCartItem']);

// Route::post('/checkout', [CartApiController::class, 'checkout']);

Route::post('/checkout', [CheckoutApiController::class, 'checkout']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AuthController;



// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');


Route::prefix('admin')
    ->middleware('admin') 
    ->name('admin.')
    ->group(function () {

        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    });
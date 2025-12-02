<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:merchant'])
    ->prefix('merchant')
    ->name('merchant.')
    ->group(function () {
        // Shop onboarding
        Route::get('/onboarding', [ShopController::class, 'onboarding'])->name('onboarding');
        Route::post('/onboarding', [ShopController::class, 'store'])->name('onboarding.store');

        // Merchant dashboard
        Route::get('/dashboard', [ShopController::class, 'dashboard'])->name('dashboard');

        // Products management
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');

        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    
        // Orders management
        Route::get('/orders', [App\Http\Controllers\OrderController::class, 'shopOrders'])->name('orders');
        Route::put('/orders/{order}', [App\Http\Controllers\OrderController::class, 'update'])->name('orders.update');
});

Route::middleware(['auth', 'role:user'])
    ->name('buyer.')
    ->group(function () {
        // Buyer routes can be added here
        Route::get('/shops', [ShopController::class, 'publicList'])->name('shops');
        Route::get('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');
        Route::post('/order/checkout')->name('order.checkout'); // To be implemented
});

require __DIR__.'/auth.php';

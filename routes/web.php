<?php

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
        // Route::get('/products/create', [ShopController::class, 'createProduct'])->name('products.create');
        // Route::get('/products/{product}/edit', [ShopController::class, 'editProduct'])->name('products.edit');
    });

require __DIR__.'/auth.php';

<?php

<<<<<<< HEAD
use App\Http\Controllers\ProfileController;
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

require __DIR__.'/auth.php';
=======
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DineInController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::middleware(['auth'])->group(function () {

    // Home / Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');

    // Saved Addresses
    Route::prefix('addresses')->name('addresses.')->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('index');
        Route::post('/', [AddressController::class, 'store'])->name('store');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');
        Route::patch('/{address}/default', [AddressController::class, 'setDefault'])->name('default');
    });

    // Cart (session-based)
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{menuId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{menuId}', [CartController::class, 'remove'])->name('cart.remove');

    // Dine-In Flow
    Route::prefix('dine-in')->name('dine-in.')->group(function () {
        Route::get('/menu', [DineInController::class, 'menu'])->name('menu');
        Route::get('/cart', [DineInController::class, 'cart'])->name('cart');
        Route::post('/checkout', [DineInController::class, 'checkout'])->name('checkout');
        Route::get('/track/{order}', [DineInController::class, 'track'])->name('track');
    });

    // Delivery Flow
    Route::prefix('delivery')->name('delivery.')->group(function () {
        Route::get('/address', [DeliveryController::class, 'address'])->name('address');
        Route::get('/menu', [DeliveryController::class, 'menu'])->name('menu');
        Route::get('/cart', [DeliveryController::class, 'cart'])->name('cart');
        Route::post('/checkout', [DeliveryController::class, 'checkout'])->name('checkout');
        Route::get('/track/{order}', [DeliveryController::class, 'track'])->name('track');
    });

    // Reviews
    Route::post('/orders/{order}/review', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__ . '/auth.php';
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722

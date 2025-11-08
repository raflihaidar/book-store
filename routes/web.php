<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hanya user biasa
    Route::middleware('role:user')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

        // Order routes
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/order', [OrderController::class, 'store'])->name('order.store');

        // Cart routes
        Route::patch('/cart/{cart}/update', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}/remove', [CartController::class, 'remove'])->name('cart.remove');

        // Checkout route
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/books', [BookController::class, 'index'])->name('books.index');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

        // Admin orders
        Route::get('/admin/orders', [OrderController::class, 'indexAdmin'])->name('admin.orders.index');
        Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
    });

    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

require __DIR__ . '/auth.php';

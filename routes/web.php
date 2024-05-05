<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('auth')->group( function() {

    Route::post('/create', [ProductController::class, 'store']);
    Route::patch('/products/update/{product}', [ProductController::class, 'update']);
    Route::get('/products/{available?}', [ProductController::class, 'index'])->name('products.all');
    Route::delete('/products/delete/{product}', [ProductController::class, 'delete'])->name('products.delete');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group( function() {

    Route::inertia('/login', 'Login')->name('login.page');
    Route::inertia('/registration', 'Registration')->name('registration');

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', [ClientController::class, 'index'])->name('client.index');

Route::prefix('products')->group(function () {

    Route::get('/', [ProductController::class, 'index'])->name('client.products.index');



});
Route::prefix('blog')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('client.blog.index');
});

Route::prefix('contact')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('client.contact.index');
});

Route::prefix('about')->group(function () {
    Route::get('/', [AboutController::class, 'index'])->name('client.about.index');
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('client.cart.index');
});

Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('client.checkout.index');
});



Route::get('/admin', [AdminProductController::class, 'index'])->name('admin.index');


Route::get('/admin/product/index', [AdminProductController::class, 'listProduct'])->name('admin.products.index');


// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
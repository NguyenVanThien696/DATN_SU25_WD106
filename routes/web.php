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


// Trang chu
Route::get('/', [ClientController::class, 'index'])->name('client.index');



// Trang product phía user 
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('client.products.index');
    Route::get('/detail/{id}', [ProductController::class, 'show'])->name('client.products.detail');


});


// Trang blog phía user  
Route::prefix('blog')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('client.blog.index');
});


// Trang contact phía user  
Route::prefix('contact')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('client.contact.index');
});


// Trang about phía user  
Route::prefix('about')->group(function () {
    Route::get('/', [AboutController::class, 'index'])->name('client.about.index');
});


// Trang cart phía user  
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('client.cart.index');
});


// Trang checkout phía user  
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('client.checkout.index');
});


// Trang product phía admin
Route::prefix('admin')->group(function () {

Route::get('/', [AdminProductController::class, 'index'])->name('admin.index');

    Route::prefix('product')->group(function () {
        Route::get('/index', [AdminProductController::class, 'listProduct'])->name('admin.products.index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/store', [AdminProductController::class,'store'])->name('admin.products.store');
        Route::get('/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/update/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/delete/{id}', [AdminProductController::class, 'delete'])->name('admin.products.delete');
        Route::get('/detail/{id}', [AdminProductController::class, 'show'])->name('admin.products.show');

    });
});


// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
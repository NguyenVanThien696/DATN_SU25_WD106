<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

use App\Http\Controllers\Auth\AuthController;


// Trang chu
Route::get('/', [ClientController::class, 'index'])->name('client.index');



// Trang product phía user 
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('client.products.index');
    Route::get('/detail/{id}', [ProductController::class, 'show'])->name('client.products.detail');


});

Route::get('/category', function () {
    return view('pages.category');
});

Route::get('/product', function () {
    return view('pages.product');
});

Route::get('/cart', function () {
    return view('pages.cart');
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
    Route::get('/cart', [CartController::class, 'index'])->name('client.cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('client.cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('client.cart.update');
    Route::get('/cart/delete/{id}', [CartController::class, 'delete'])->name('client.cart.delete');
    Route::get('/cart/clear', [CartController::class, 'clear'])->name('client.cart.clear');
});


// Trang checkout phía user  
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('client.checkout.index');
    Route::get('/thankyou', function(){
        return view('client.checkout.thankyou');
    })->name('client.checkout.thankyou');
});


// Trang product phía admin


// Login routes (không cần auth)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Routes dành cho người dùng đã đăng nhập
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard.form');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('user.changePassword');
});

// Admin Routes (yêu cầu đăng nhập + admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'adminIndex'])->name('home');
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('product')->group(function () {
        Route::get('/index', [AdminProductController::class, 'listProduct'])->name('products.index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/store', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/edit/{id}', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/update/{id}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/delete/{id}', [AdminProductController::class, 'delete'])->name('products.delete');
        Route::get('/detail/{id}', [AdminProductController::class, 'show'])->name('products.show');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/index', [AdminCategoryController::class, 'listCate'])->name('categories.index');
        Route::get('/create', [AdminCategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('/edit/{id}', [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/update/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/delete/{id}', [AdminCategoryController::class, 'delete'])->name('categories.delete');
        Route::get('/detail/{id}', [AdminCategoryController::class, 'show'])->name('categories.show');
    });
});
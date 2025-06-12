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

    Route::prefix('categories')->group(function(){
        Route::get('/index', [AdminCategoryController::class, 'listCate'])->name('admin.categories.index');
        Route::get('/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/store', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/update/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/delete/{id}', [AdminCategoryController::class, 'delete'])->name('admin.categories.delete');
        Route::get('/detail/{id}', [AdminCategoryController::class, 'show'])->name('admin.categories.show');

    });
});


// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');

    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('user.changePassword');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.users');
});
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\CouponController;
use App\Http\Controllers\Client\OrderController;


use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;


use App\Http\Controllers\Auth\AuthController;
// Trang chu
Route::get('/', [ClientController::class, 'index'])->name('client.index');
// Route::get('/', [ClientController::class, 'index'])->name('client.index');



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


//Search
Route::get('/search', [ProductController::class, 'search'])->name('client.search.index');



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

      
    Route::prefix('client')->name('client.')->group(function () {


        // Trang cart phía user 
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add', [CartController::class, 'add'])->name('add');
            Route::post('/update', [CartController::class, 'update'])->name('update');
            Route::get('/delete/{variant_id}', [CartController::class, 'delete'])->name('delete');
            Route::get('/clear', [CartController::class, 'clear'])->name('clear');
        });

        // Checkout user
        Route::prefix('checkout')->name('checkout.')->group(function () {
            Route::get('/', [CheckoutController::class, 'index'])->name('index');
            Route::post('/', [CheckoutController::class, 'process'])->name('process');
            Route::post('/apply-coupon', [CheckoutController::class, 'apply'])->name('coupon.apply');
            Route::get('/vnpay-return', [CheckoutController::class, 'vnpayReturn'])->name('vnpayReturn');
            Route::get('/momo-return', [CheckoutController::class, 'momoReturn'])->name('momoReturn');
            Route::post('/momo-ipn', [CheckoutController::class, 'momoIPN'])->name('momoIPN');
            Route::get('/thankyou', [CheckoutController::class, 'thankyou'])->name('thankyou');

        });

            // Order user
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('/', [OrderController::class, 'listOrder'])->name('index');
            Route::get('/detail/{id}', [OrderController::class, 'detail'])->name('detail');
            Route::post('/cancel/{id}/', [OrderController::class, 'cancel'])->name('cancel');

        });


    });
});



// Admin Routes (yêu cầu đăng nhập + admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'adminIndex'])->name('home');
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



// Route Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.users');
});


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Product admin
    Route::prefix('product')->group(function () {
        Route::get('/index', [AdminProductController::class, 'listProduct'])->name('products.index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/store', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/edit/{id}', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/update/{id}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/delete/{id}', [AdminProductController::class, 'delete'])->name('products.delete');
        Route::get('/detail/{id}', [AdminProductController::class, 'show'])->name('products.show');
    });

    // Category admin
    Route::prefix('categories')->group(function () {
        Route::get('/index', [AdminCategoryController::class, 'listCate'])->name('categories.index');
        Route::get('/create', [AdminCategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('/edit/{id}', [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/update/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/delete/{id}', [AdminCategoryController::class, 'delete'])->name('categories.delete');
        Route::get('/detail/{id}', [AdminCategoryController::class, 'show'])->name('categories.show');
    });


    // Order admin
    Route::prefix('order')->name('order.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'listOrder'])->name('index');
        Route::put('status/{id}', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/detail/{id}', [AdminOrderController::class, 'detail'])->name('detail');
        Route::post('/refund/{id}', [AdminOrderController::class, 'refund'])->name('refund');
    });
});
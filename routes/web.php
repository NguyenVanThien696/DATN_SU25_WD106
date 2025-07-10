<?php

use App\Http\Controllers\Admin\AdminVoucherController;
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
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;


use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\ProductReviewController;
use App\Models\ProductReview;

// Trang chu
Route::get('/', [ClientController::class, 'index'])->name('client.index');
// Route::get('/', [ClientController::class, 'index'])->name('client.index');



// Trang product phía user 
Route::prefix('client')->name('client.')->group(function () {

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [ProductController::class, 'show'])->name('detail');
        Route::get('/boy', [ProductController::class, 'boy'])->name('boy');
        Route::get('/girl', [ProductController::class, 'girl'])->name('girl');
        Route::get('/hot', [ProductController::class, 'hot'])->name('hot');
        Route::get('/new', [ProductController::class, 'new'])->name('new');
    });
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

Route::get('/client/reviews/{product}', [ProductReviewController::class, 'store'])->name('client.reviews.store');

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

        //Reviews
        Route::prefix('reviews')->group(function () {
            Route::post('/', [ProductReviewController::class, 'store'])->name('reviews.store');
        });
    });
});



// Admin Routes (yêu cầu đăng nhập + admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'adminIndex'])->name('index');
    Route::get('home', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user', [UserController::class, 'index'])->name('users');
});



// Route Admin
// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/user', [UserController::class, 'index'])->name('admin.users');
//     Route::get('admin/home', [DashboardController::class, 'index'])->name('admin.home');
// });


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Product admin
    Route::prefix('product')->group(function () {
        Route::get('/index', [AdminProductController::class, 'listProduct'])->name('products.index');
        Route::get('/filter', [AdminProductController::class, 'filter'])->name('product.filter');
        Route::get('/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/store', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/edit/{id}', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/update/{id}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/delete/{id}', [AdminProductController::class, 'delete'])->name('products.delete');
        Route::get('/detail/{id}', [AdminProductController::class, 'show'])->name('products.show');
        Route::get('/create/size', [AdminProductController::class, 'createSize'])->name('products.createSize');
        Route::post('/store/size', [AdminProductController::class, 'storeSize'])->name('products.storeSize');
        Route::get('/create/color', [AdminProductController::class, 'createColor'])->name('products.createColor');
        Route::post('/store/color', [AdminProductController::class, 'storeColor'])->name('products.storeColor');
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
        Route::get('/filter', [AdminOrderController::class, 'index'])->name('filter');
        Route::put('status/{id}', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/detail/{id}', [AdminOrderController::class, 'detail'])->name('detail');
        Route::post('/refund/{id}', [AdminOrderController::class, 'refund'])->name('refund');
    });

    Route::prefix('vouchers')->name('vouchers.')->group(function () {
        Route::get('/', [AdminVoucherController::class, 'index'])->name('index');
        Route::get('/create', [AdminVoucherController::class, 'create'])->name('create');
        Route::post('/store', [AdminVoucherController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AdminVoucherController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [AdminVoucherController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AdminVoucherController::class, 'destroy'])->name('delete');
        Route::patch('/toggle-status/{id}', [AdminVoucherController::class, 'toggleStatus'])->name('toggleStatus');

    });
    // Reviews admin
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::delete('/delete/{id}', [ReviewController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'staffDashboard'])->name('dashboard');
    Route::get('/', [AuthController::class, 'staffIndex'])->name('home');

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'listOrder'])->name('index'); // Xem tất cả đơn
        Route::get('/detail/{id}', [AdminOrderController::class, 'detail'])->name('detail'); // Chi tiết đơn
        Route::put('/status/{id}', [AdminOrderController::class, 'updateStatus'])->name('updateStatus'); // Cập nhật trạng thái
    });
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminProductController::class, 'listProduct'])->name('index');
        Route::get('/edit/{id}', [AdminProductController::class, 'edit'])->name('edit'); // Chỉnh sửa số lượng tồn
        Route::put('/update/{id}', [AdminProductController::class, 'update'])->name('update');
    });
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index'); // Xem tất cả
        Route::delete('/delete/{id}', [ReviewController::class, 'destroy'])->name('destroy'); // Xoá nếu cần
    });
});

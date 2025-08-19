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
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\CategoriesController;
use App\Http\Controllers\Client\ProductReviewController;
use App\Http\Controllers\Client\RefundRequestController;
use App\Http\Controllers\Client\WalletController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\RefundRequestController as AdminRefundRequestController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\WalletTransactionController as AdminWalletTransactionController;
use App\Http\Controllers\Auth\AuthController;
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

// Danh mục phía user
Route::get('/categories/{id}', [CategoriesController::class, 'show'])->name('client.products.categories');

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

// Quên mật khẩu
// Giao diện nhập email để đặt lại mật khẩu
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
// Gửi mail đặt lại mật khẩu
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// Giao diện đặt lại mật khẩu với token
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
// Gửi mật khẩu mới
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Routes dành cho người dùng đã đăng nhập
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard.form');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('user.changePassword');
    Route::get('/user/edit', [AuthController::class, 'edit'])->name('user.edit');
    Route::put('/user/update', [AuthController::class, 'update'])->name('user.update');


    Route::prefix('client')->name('client.')->group(function () {

        // Ví
        Route::prefix('wallet')->name('wallet.')->group(function () {
            Route::get('refund/create/{orderId}', [RefundRequestController::class, 'create'])->name('refund.create');
            Route::post('refund/store', [RefundRequestController::class, 'store'])->name('refund.store');
            Route::get('/', [WalletController::class, 'index'])->name('index');
            // Nạp tiền
            Route::get('deposit', [WalletController::class, 'showDepositForm'])->name('deposit');
            Route::post('deposit', [WalletController::class, 'DepositRedirect'])->name('deposit.redirect');
            Route::get('deposit/callback', [WalletController::class, 'DepositCallback'])->name('deposit.callback');
            // Rút tiền
            Route::get('withdraw', [WalletController::class, 'showWithdrawForm'])->name('withdraw');
            Route::post('withdraw', [WalletController::class, 'withdraw'])->name('withdraw.store');
        });



        // Trang cart phía user 
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add', [CartController::class, 'add'])->name('add');
            Route::post('/update', [CartController::class, 'update'])->name('update');
            Route::get('/delete/{variant_id}', [CartController::class, 'delete'])->name('delete');
            Route::get('/clear', [CartController::class, 'clear'])->name('clear');
            Route::post('/update-quantity', [CartController::class, 'updateQuantity'])->name('updateQuantity');
            Route::get('/check-stock', [CartController::class, 'checkStock'])->name('checkStock');
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
            Route::patch('/confirm-received/{id}', [OrderController::class, 'confirmReceived'])->name('confirmReceived');
            Route::get('/order-status/{id}', [OrderController::class, 'getStatus'])->name('getStatus');
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


    // Ví 
    Route::prefix('wallet')->name('wallet.')->group(function () {
        // Giao dịch ví
        Route::get('transactions', [AdminWalletTransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/{user}', [AdminWalletTransactionController::class, 'show'])->name('transactions.user');
        // Nạp tiền admin
        Route::get('deposit', [AdminWalletTransactionController::class, 'adminDepositForm'])->name('deposit.admin.form');
        Route::post('deposit', [AdminWalletTransactionController::class, 'adminDepositRedirect'])->name('deposit.admin.redirect');
        Route::get('deposit/callback', [AdminWalletTransactionController::class, 'adminDepositCallback'])->name('deposit.admin.callback');
        // Quản lý yêu cầu hoàn tiền
        Route::get('refund-requests', [AdminRefundRequestController::class, 'index'])->name('refund-requests.index');
        Route::get('refund-requests/{id}', [AdminRefundRequestController::class, 'show'])->name('refund-requests.show');
        Route::put('refund-requests/{id}', [AdminRefundRequestController::class, 'update'])->name('refund-requests.update');
    });


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

        Route::get('/indexVariant', [AdminProductController::class, 'indexVariant'])->name('products.indexVariant');

        Route::get('/create/size', [AdminProductController::class, 'createSize'])->name('products.createSize');
        Route::post('/store/size', [AdminProductController::class, 'storeSize'])->name('products.storeSize');
        Route::get('/edit/size/{id}', [AdminProductController::class, 'editSize'])->name('products.editSize');
        Route::put('/update/size/{id}', [AdminProductController::class, 'updateSize'])->name('products.updateSize');
        Route::delete('/delete/size/{id}', [AdminProductController::class, 'deleteSize'])->name('products.deleteSize');

        Route::get('/create/color', [AdminProductController::class, 'createColor'])->name('products.createColor');
        Route::post('/store/color', [AdminProductController::class, 'storeColor'])->name('products.storeColor');
        Route::get('/edit/color/{id}', [AdminProductController::class, 'editColor'])->name('products.editColor');
        Route::put('/update/color/{id}', [AdminProductController::class, 'updateColor'])->name('products.updateColor');
        Route::delete('/delete/color/{id}', [AdminProductController::class, 'deleteColor'])->name('products.deleteColor');
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
        Route::get('/statuses/{id}', [AdminOrderController::class, 'getStatuses'])->name('getStatuses');
    });

    // Vouchers admin
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


    // Banner admin
    Route::prefix('banners')->name('banners.')->group(function () {
        Route::get('/', [AdminBannerController::class, 'index'])->name('index');
        Route::get('/create', [AdminBannerController::class, 'create'])->name('create');
        Route::post('/store', [AdminBannerController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AdminBannerController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [AdminBannerController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AdminBannerController::class, 'destroy'])->name('destroy');
        Route::get('/detail/{id}', [AdminBannerController::class, 'show'])->name('show');
        Route::patch('/toggle-status/{id}', [AdminBannerController::class, 'toggleStatus'])->name('toggleStatus');
    });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\AboutController;

use App\Http\Controllers\Admin\ProductController as AdminProductController;



Route::get('/', [ClientController::class, 'index'])->name('client.index');

Route::prefix('shop')->group(function () {

    Route::get('/products', [ProductController::class, 'index'])->name('client.products.index');

    Route::get('/blog', [PostController::class, 'index'])->name('client.blog.index');

    Route::get('/contact', [ContactController::class, 'index'])->name('client.contact.index');

    Route::get('/about', [AboutController::class, 'index'])->name('client.about.index');

});

Route::get('/admin', [AdminProductController::class, 'index'])->name('admin.layouts.default');



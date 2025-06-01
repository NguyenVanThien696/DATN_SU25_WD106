<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ClientController;


Route::get('/', function () {
    return view('client.index');
});
Route::get('/admin', function () {
    return view('admin.layouts.default');
});

// Route::get('/', [ClientController::class, 'index'])->name('client.index');

Route::get('/category', function () {
    return view('pages.category');
});

Route::get('/product', function () {
    return view('pages.product');
});

Route::get('/cart', function () {
    return view('pages.cart');
});
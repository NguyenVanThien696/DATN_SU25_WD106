<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
        public function index()
    {
        return view('client.products.index');
    }
}

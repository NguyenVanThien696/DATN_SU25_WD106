<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
public function index()
{
    $listProducts = Product::with(['variants.size', 'variants.color'])->latest()->paginate(12);

    return view('client.products.index', compact('listProducts'));
}

// ShopController
public function show($id)
{
        $product = Product::with(['variants.size', 'variants.color'])->findOrFail($id);

    $sizes = ProductVariant::getSizesByProduct($id);
    $colors = ProductVariant::getColorsByProduct($id);
    $product_variants = $product->variants;
    return view('client.products.detail', compact('product', 'sizes', 'colors'));
}


}
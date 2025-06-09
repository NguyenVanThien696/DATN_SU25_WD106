<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
    $product = Product::with(['variants.size', 'variants.color', 'category', 'brand'])->findOrFail($id);

    $variants = $product->variants->map(function($variant){
        return [
            'id' => $variant->id,
            'size_id' => $variant->size_id,
            'color_id' => $variant->color_id,
            'stock' => $variant->stock,
        ];
    });
    $stock = $variants->sum('stock');
    return view('client.products.detail', compact('product', 'variants', 'stock'));
}


}
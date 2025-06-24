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

    //Sản phẩm liên quan
    $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->latest()->take(4)->get();
    return view('client.products.detail', compact('product', 'variants', 'stock', 'relatedProducts'));
}

public function search(Request $request){
    $keyword = $request->input('s') ?? $request->input('keyword');

    if(!$keyword){
        return view('client.search.index', ['products' => collect(), 'keyword' => $keyword]);
    }

    $keywords = explode(' ', $keyword);

    $products = Product::query();
    
    foreach ($keywords as $word) {
        $products->where(function($query) use ($word){
            $query->where('name', 'LIKE', '%' .$word. '%')->orWhere('description', 'LIKE', '%' .$word. '%');
        });
    }

    $products = $products->get();

    return view('client.search.index', compact('products', 'keyword'));
}


}
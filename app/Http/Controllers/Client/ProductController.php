<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
public function index()
{
    $listProducts = Product::with(['tag','variants.size', 'variants.color'])->latest()->paginate(12);

    return view('client.products.index', compact('listProducts'));
}

// ShopController
public function show($id)
{
    $product = Product::with(['variants.size', 'variants.color', 'category', 'brand', 'reviews.user'])->findOrFail($id);

    $variants = $product->variants->map(function($variant){
        return [
            'id' => $variant->id,
            'size_id' => $variant->size_id,
            'color_id' => $variant->color_id,
            'stock' => $variant->stock,
        ];
    });
    $stock = $variants->sum('stock');

    $hasPurchased = false;

    if(Auth::check()){
        $hasPurchased = OrderItem::whereHas('order', function($query){
            $query->where('user_id', Auth::id())->where('status', 'completed') ;
        })->whereHas('productVariant', function($query) use($product){
            $query->where('product_id', $product->id);
        })->exists();
    }

    //Sản phẩm liên quan
    $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->latest()->take(4)->get();
    return view('client.products.detail', compact('product', 'variants', 'stock', 'relatedProducts', 'hasPurchased'));
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

public function boy()
{
    $listboy = Product::with(['tag','variants.size', 'variants.color'])
        ->where('category_id', 3)
        ->latest()
        ->paginate(12);

    return view('client.products.menu.boy', compact('listboy'));
}

public function girl()
{
    $listgirl = Product::with(['tag','variants.size', 'variants.color'])
        ->where('category_id', 4)
        ->latest()
        ->paginate(12);

    return view('client.products.menu.girl', compact('listgirl'));
}

public function hot()
{
    $listhot = Product::with(['tag','variants.size', 'variants.color'])
        ->where('tag_id', 2)
        ->latest()
        ->paginate(12);

    return view('client.products.menu.hot', compact('listhot'));
}

public function new()
{
    $listnew = Product::with(['tag','variants.size', 'variants.color'])
        ->where('tag_id', 1)
        ->latest()
        ->paginate(12);

    return view('client.products.menu.new', compact('listnew'));
}
}
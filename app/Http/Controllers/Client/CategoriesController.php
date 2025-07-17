<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show($id){
        $category = Category::findOrFail($id);
        $breadcrumbs = [
            (object)['name' => 'Cửa hàng', 'route' => route('client.products.index')],
            (object)['name' => $category->name, 'route' => route('client.products.categories', ['id' => $category->id])],
        ];
        $products = Product::where('category_id', $id)->get();

        return view('client.categories.index', compact('category', 'breadcrumbs', 'products'));
    }
}

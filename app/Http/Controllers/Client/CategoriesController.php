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
        $products = Product::where('category_id', $id)->get();

        return view('client.categories.index', compact('category', 'products'));
    }
}

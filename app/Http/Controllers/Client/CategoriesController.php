<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show($id){
        $categories = Category::all();
        $currentCategory = Category::findOrFail($id);
        $listProducts = $currentCategory->products()->paginate(12);

        return view('client.products.index', compact('listProducts', 'categories', 'currentCategory'));
    }
}

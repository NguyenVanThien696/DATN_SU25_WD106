<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function listProduct(){
        $listProducts = Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->join('brands', 'products.brand_id', '=', 'brands.id')
        ->select('products.id',
                            'products.name',
                            'products.description',
                            'products.price',
                            'products.quantity',
                            'products.image',
                            'categories.name as category_name',
                            'brands.name as brand_name')
                            ->orderBy('products.created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('listProducts'));
    }

    
}
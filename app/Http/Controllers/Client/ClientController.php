<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientController extends Controller
{
public function index()
{
    $listProducts = Product::with(['tag', 'variants.size', 'variants.color'])
        ->whereHas('tag', function ($query) {
            $query->where('name', 'hot');
        })
        ->latest()
        ->take(3)
        ->get();

    return view('client.index', compact('listProducts'));
}


}
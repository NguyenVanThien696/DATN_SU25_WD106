<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
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

    $banners = Banner::active()
        ->where('position', 'homepage')
        ->orderByDesc('created_at')
        ->get();

    return view('client.index', compact('listProducts', 'banners'));
}


}
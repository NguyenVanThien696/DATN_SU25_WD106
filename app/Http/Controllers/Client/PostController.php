<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
        public function index()
    {
        return view('client.blog.index');
    }
}
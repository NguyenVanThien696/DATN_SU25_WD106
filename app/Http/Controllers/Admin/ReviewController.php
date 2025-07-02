<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(){
        $reviews = ProductReview::with(['product', 'user'])->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy($id){
        $reviews = ProductReview::findOrFail($id);
        $reviews->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Xoá đánh giá thành công');
    }
}

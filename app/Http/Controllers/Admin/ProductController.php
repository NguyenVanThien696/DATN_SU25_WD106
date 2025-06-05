<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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

    public function create(){
    $category = Category::select('id', 'name')->get();
    $brand = Brand::select('id', 'name')->get();
    return view('admin.products.create', compact('category', 'brand'));
    }

    public function store(Request $request){
        
    // dd($request->all());

    $request->validate([
        'category_id' =>'required',
        'brand_id' =>'required',
        'name' =>'required|min:3|max:100',
        'description' =>'nullable|string|max:255',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'price' =>'required|numeric|min:0',
        'quantity' =>'required|numeric|min:0'
    ], [
        'name' => 'Tên sản phẩm dài từ 3 đến 100 kí tự.',
        // 'image' => 'Ảnh là bắt buộc.',
        'price' => 'Giá sản phẩm không được để trống.',
        'quantity' => 'Số lượng phải lớn hơn hoặc bằng 0.',
    ]);

    $path = null;
    if ($request->hasFile('image')) {
    $path = $request->file('image')->store('uploads', 'public');
    }

        Product::create([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $path,
        ]);
        // dd($product);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

        public function edit($id) {
        $product = Product::where('id', $id)->first();
        $category = Category::select('id', 'name')->get();
        $brand = Brand::select('id', 'name')->get();
        return view('admin.products.edit', compact('product', 'category', 'brand'));
    }

        public function update(Request $request, $id) {

        $request->validate([
        'category_id' =>'required',
        'brand_id' =>'required',
        'name' =>'required|min:3|max:100',
        'description' =>'nullable|string|max:255',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'price' =>'required|numeric|min:0',
        'quantity' =>'required|numeric|min:0'
    ], [
        'name' => 'Tên sản phẩm dài từ 3 đến 100 kí tự.',
        // 'image' => 'Ảnh là bắt buộc.',
        'price' => 'Giá sản phẩm không được để trống.',
        'quantity' => 'Số lượng phải lớn hơn hoặc bằng 0.',
    ]);
        
        $product = Product::findOrFail($id);
        $path = $product->image;


        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('uploads', 'public');
        }
    
    
        $product->update([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $path,
        ]);


        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
}

    public function delete($id) {

        $product = Product::where('id', $id)->first();
        if($product->first()->image != null && $product->first()->image != ''){
            File::delete(public_path($product->image));
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
    
    public function show($id)
{
    $product = Product::with('category', 'brand')->findOrFail($id);
    return view('admin.products.detail', compact('product'));
}
}
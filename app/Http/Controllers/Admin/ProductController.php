<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Tag;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index(){
        return view('admin.index');
    }

public function listProduct()
{
    $listProducts = Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->join('brands', 'products.brand_id', '=', 'brands.id')
        // ->join('tags', 'products.tag_id', '=', 'tags.id')
        ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
        ->select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.image',
            'categories.name as category_name',
            'brands.name as brand_name',
            // 'tags.name as tag_name',
            DB::raw('SUM(product_variants.stock) as total_stock')
        )
        ->groupBy(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.image',
            'categories.name',
            'brands.name',
            // 'tags.name'
        )
        ->orderBy('products.created_at', 'desc')
        ->paginate(10);

    return view('admin.products.index', compact('listProducts'));
}


    public function create(){
    $category = Category::select('id', 'name')->get();
    $brand = Brand::select('id', 'name')->get();
    $sizes = Size::select('id', 'name')->get();
    $colors = Color::select('id', 'name')->get();
    $tags = Tag::select('id', 'name')->get();
    return view('admin.products.create', compact('category', 'brand', 'sizes', 'colors', 'tags'));
    }

public function store(Request $request) {
    // dd($request->all());
    // dd($request->all(), $request->file('variants'));
    $request->validate([
        'name' => 'required|string|min:3|max:100',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
        'tag_id' => 'required|exists:tags,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'variants' => 'required|array|min:1',
        'variants.*.size_id' => 'required|exists:sizes,id',
        'variants.*.color_id' => 'required|exists:colors,id',
        'variants.*.stock' => 'required|integer|min:0',
        'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    
    $variantPairs = [];
    foreach ($request->variants as $variant) {
        $key = $variant['size_id'] . '-' . $variant['color_id'];
        if (in_array($key, $variantPairs)) {
            return back()->with(['error' => 'Có biến thể bị trùng size và màu. Vui lòng kiểm tra lại.']);
        }
        $variantPairs[] = $key;
    }

    $product = new Product();
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->category_id = $request->category_id;
    $product->brand_id = $request->brand_id;
    $product->tag_id = $request->tag_id;

    if ($request->hasFile('image')) {
        $product->image = $request->file('image')->store('products', 'public');
    }

    $product->save();

    foreach ($request->variants as $index => $variant) {
        $variantData = [
            'size_id' => $variant['size_id'],
            'color_id' => $variant['color_id'],
            'stock' => $variant['stock'],
        ];

        if (isset($variant['image']) && $variant['image'] instanceof \Illuminate\Http\UploadedFile) {
            $variantData['image'] = $variant['image']->store('variant-images', 'public');
        }

        $product->variants()->create($variantData);
    }

    return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công');
}


        public function edit($id) {
        $product = Product::where('id', $id)->first();
        $category = Category::select('id', 'name')->get();
        $brand = Brand::select('id', 'name')->get();
        $sizes = Size::select('id', 'name')->get();
        $colors = Color::select('id', 'name')->get();
        $tag = Tag::select('id', 'name')->get();
        return view('admin.products.edit', compact('product', 'category', 'brand', 'sizes', 'colors', 'tag'));
    }

public function update(Request $request, $id)
{
    $request->validate([
        'category_id' => 'required',
        'brand_id' => 'required',
        'tag_id' => 'required',
        'name' => 'required|min:3|max:100',
        'description' => 'nullable|string|max:500',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'price' => 'required|numeric|min:0',
        'variants' => 'required|array|min:1',
        'variants.*.size_id' => 'required|exists:sizes,id',
        'variants.*.color_id' => 'required|exists:colors,id',
        'variants.*.stock' => 'required|integer|min:0',
        'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Kiểm tra biến thể trùng size & màu
    $variantPairs = [];
    foreach ($request->variants as $variant) {
        $key = $variant['size_id'] . '-' . $variant['color_id'];
        if (in_array($key, $variantPairs)) {
            return back()->withInput()->with('error', 'Có biến thể bị trùng size và màu. Vui lòng kiểm tra lại.');
        }
        $variantPairs[] = $key;
    }

    $product = Product::findOrFail($id);

    // Kiểm tra nếu biến thể bị loại khỏi form mà đang có liên kết đơn hàng → báo lỗi
    $requestVariantIds = collect($request->variants)->pluck('id')->filter()->toArray();
    $cannotDelete = $product->variants()
        ->whereNotIn('id', $requestVariantIds)
        ->whereHas('orderItems')
        ->get();

    if ($cannotDelete->isNotEmpty()) {
        return back()->withInput()->with('error', 'Không thể cập nhật sản phẩm vì có biến thể đã liên kết với đơn hàng mà bạn đang cố gắng loại bỏ.');
    }

    // Xử lý ảnh sản phẩm
    $path = $product->image;
    if ($request->hasFile('image')) {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $path = $request->file('image')->store('products', 'public');
    }

    // Cập nhật sản phẩm chính
    $product->update([
        'category_id' => $request->category_id,
        'brand_id' => $request->brand_id,
        'tag_id' => $request->tag_id,
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'image' => $path,
    ]);

    // Cập nhật hoặc tạo biến thể
    foreach ($request->variants as $index => $variantData) {
        $variant = null;

        if (!empty($variantData['id'])) {
            $variant = $product->variants()->find($variantData['id']);
        }

        $variantImagePath = null;
        if ($request->hasFile("variants.$index.image")) {
            $variantImagePath = $request->file("variants.$index.image")->store("variants", "public");

            // Xoá ảnh cũ nếu có
            if ($variant && $variant->image && Storage::disk('public')->exists($variant->image)) {
                Storage::disk('public')->delete($variant->image);
            }
        }

        if ($variant) {
            $variant->update([
                'size_id' => $variantData['size_id'],
                'color_id' => $variantData['color_id'],
                'stock' => $variantData['stock'],
                'image' => $variantImagePath ?? $variant->image,
            ]);
        } else {
            $product->variants()->create([
                'size_id' => $variantData['size_id'],
                'color_id' => $variantData['color_id'],
                'stock' => $variantData['stock'],
                'image' => $variantImagePath,
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
}



    public function delete($id) {

        $product = Product::findOrFail($id);

    foreach ($product->variants as $variant) {
        if ($variant->orderItems()->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Không thể xóa sản phẩm vì đã có đơn hàng liên quan.');
        }
    }
    if ($product->image) {
        Storage::delete('public/' . $product->image);
    }
    foreach ($product->variants as $variant) {
        if ($variant->image) {
            Storage::delete('public/' . $variant->image);
        }
    }
    $product->variants()->delete();
    $product->delete();

    return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
}
    
    public function show($id)
    {
        $product = Product::with([
            'category',
            'brand',
            'tag',
            'variants.size',
            'variants.color'
        ])->findOrFail($id);

        return view('admin.products.detail', compact('product'));
    }

    public function createSize(){
        return view('admin.products.productvariants.sizes.create');
    }

    public function storeSize(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
        ]);

        Size::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.products.createSize')->with('success', 'Thêm biến thể kích thước sản phẩm thành công');

    }

    public function createColor(){
        return view('admin.products.productvariants.colors.create');
    }

    public function storeColor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
        ]);

        Color::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.products.createColor')->with('success', 'Thêm biến thể màu sản phẩm thành công');

    }

}
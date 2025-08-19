<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Tag;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
public function index()
{
    $notifications = Auth::user()->unreadNotifications; // hoặc thông báo tùy chỉnh
    $totalNotifications = $notifications->count();

    return view('admin.index', compact('notifications', 'totalNotifications'));
}



    public function listProduct()
    {
        $listProducts = Product::with(['category', 'brand']) 
            ->withSum('variants as total_stock', 'stock')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.products.index', compact('listProducts'));
    }



    public function create()
    {
        $category = Category::select('id', 'name')->get();
        $brand = Brand::select('id', 'name')->get();
        $sizes = Size::select('id', 'name')->get();
        $colors = Color::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();
        return view('admin.products.create', compact('category', 'brand', 'sizes', 'colors', 'tags'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request->all(), $request->file('variants'));
$request->validate([
    'name' => 'required|string|min:3|max:100',
    'price' => 'required|numeric|min:0',
    'category_id' => 'required|exists:categories,id',
    'brand_id' => 'required|exists:brands,id',
    'tag_id' => 'required|exists:tags,id',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',

    'variants' => 'required|array|min:1',
    'variants.*.size_id' => 'required|exists:sizes,id',
    'variants.*.color_id' => 'required|exists:colors,id',
    'variants.*.stock' => 'required|integer|min:0',
    'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
], [
    'name.required' => 'Tên sản phẩm không được để trống.',
    'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
    'name.min' => 'Tên sản phẩm không hợp lệ.',
    'name.max' => 'Tên sản phẩm không hợp lệ.',

    'price.required' => 'Giá không được để trống.',
    'price.numeric' => 'Giá phải là số.',
    'price.min' => 'Giá không được âm.',

    'category_id.required' => 'Vui lòng chọn danh mục.',
    'category_id.exists' => 'Danh mục không hợp lệ.',

    'brand_id.required' => 'Vui lòng chọn thương hiệu.',
    'brand_id.exists' => 'Thương hiệu không hợp lệ.',

    'tag_id.required' => 'Vui lòng chọn tag.',
    'tag_id.exists' => 'Tag không hợp lệ.',

    'image.image' => 'File tải lên phải là hình ảnh.',
    'image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
    'image.max' => 'Hình ảnh không được vượt quá 2MB.',

    'variants.required' => 'Cần thêm ít nhất một biến thể.',
    'variants.min' => 'Phải có ít nhất một biến thể.',

    'variants.*.size_id.required' => 'Vui lòng chọn size cho biến thể.',
    'variants.*.size_id.exists' => 'Size của biến thể không hợp lệ.',

    'variants.*.color_id.required' => 'Vui lòng chọn màu cho biến thể.',
    'variants.*.color_id.exists' => 'Màu của biến thể không hợp lệ.',

    'variants.*.stock.required' => 'Vui lòng nhập số lượng cho biến thể.',
    'variants.*.stock.integer' => 'Số lượng của biến thể phải là số nguyên.',
    'variants.*.stock.min' => 'Số lượng của biến thể không được âm.',

    'variants.*.image.image' => 'Ảnh của biến thể phải là hình ảnh.',
    'variants.*.image.mimes' => 'Ảnh của biến thể phải có định dạng jpeg, png, jpg hoặc gif.',
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


    public function edit($id)
    {
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
        'name' => 'required|string|min:3|max:100',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
        'tag_id' => 'required|exists:tags,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'variants' => 'required|array|min:1',
        'variants.*.size_id' => 'required|exists:sizes,id',
        'variants.*.color_id' => 'required|exists:colors,id',
        'variants.*.stock' => 'required|integer|min:0',
        'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ], [
        'name.required' => 'Tên sản phẩm không được để trống.',
        'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
        'name.min' => 'Tên sản phẩm không hợp lệ.',
        'name.max' => 'Tên sản phẩm không hợp lệ.',
        'price.required' => 'Giá không được để trống.',
        'price.numeric' => 'Giá phải là số.',
        'price.min' => 'Giá không được âm.',
        'category_id.required' => 'Vui lòng chọn danh mục.',
        'category_id.exists' => 'Danh mục không hợp lệ.',
        'brand_id.required' => 'Vui lòng chọn thương hiệu.',
        'brand_id.exists' => 'Thương hiệu không hợp lệ.',
        'tag_id.required' => 'Vui lòng chọn tag.',
        'tag_id.exists' => 'Tag không hợp lệ.',
        'image.image' => 'File tải lên phải là hình ảnh.',
        'image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
        'image.max' => 'Hình ảnh không được vượt quá 2MB.',
        'variants.required' => 'Phải có ít nhất một biến thể.',
        'variants.array' => 'Biến thể phải là một mảng.',
        'variants.*.size_id.required' => 'Vui lòng chọn size cho từng biến thể.',
        'variants.*.size_id.exists' => 'Size không hợp lệ.',
        'variants.*.color_id.required' => 'Vui lòng chọn màu cho từng biến thể.',
        'variants.*.color_id.exists' => 'Màu không hợp lệ.',
        'variants.*.stock.required' => 'Vui lòng nhập số lượng cho từng biến thể.',
        'variants.*.stock.integer' => 'Số lượng phải là số nguyên.',
        'variants.*.stock.min' => 'Số lượng không được âm.',
        'variants.*.image.image' => 'Ảnh biến thể phải là hình ảnh.',
        'variants.*.image.mimes' => 'Ảnh biến thể phải có định dạng jpeg, png, jpg hoặc gif.',
        'variants.*.image.max' => 'Ảnh biến thể không được vượt quá 2MB.',
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



    public function delete($id)
    {

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


            public function indexVariant()
    {
            $colors = Color::all();
            $sizes = Size::all();
        return view('admin.products.productvariants.index', compact('colors', 'sizes'));
    }

    public function createSize(){
        return view('admin.products.productvariants.sizes.create');

    }

public function storeSize(Request $request)
{
    $request->validate([
        'name' => 'required|string|min:2|max:100',
    ], [
        'name.required' => 'Vui lòng nhập tên.',
        'name.string'   => 'Tên phải là chuỗi ký tự.',
        'name.min'      => 'Tên phải có ít nhất 2 ký tự.',
        'name.max'      => 'Tên không được vượt quá 100 ký tự.',
    ]);

    $exists = Size::whereRaw('LOWER(name) = ?', [strtolower($request->name)])->exists();

    if ($exists) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Tên kích cỡ đã tồn tại.');
    }

    Size::create([
        'name' => $request->name,
    ]);

    return redirect()
        ->route('admin.products.indexVariant')
        ->with('success', 'Thêm biến thể kích cỡ mới thành công!');
}



public function editSize($id)
{
    $item = Size::findOrFail($id);
    return view('admin.products.productvariants.edit', [
        'item' => $item,
        'type' => 'size',
    ]);
}

public function updateSize(Request $request, $id)
{
    $request->validate(['name' => 'required|string|max:255']);
    $size = Size::findOrFail($id);
    $size->update(['name' => $request->name]);
    return redirect()->route('admin.products.indexVariant')->with('success', 'Cập nhật kích cỡ thành công!');
}

public function deleteSize($id)
{
    $size = Size::findOrFail($id);

    $hasProduct = ProductVariant::where('size_id', $id)->exists();

    if ($hasProduct) {
        return redirect()->route('admin.products.indexVariant')->with('error', 'Không thể xoá kích cỡ vì đang được sử dụng trong sản phẩm hoặc đơn hàng.');
    }

    $size->delete();
    return redirect()->route('admin.products.indexVariant')->with('success', 'Xoá kích cỡ thành công!');
}


    public function createColor(){
        return view('admin.products.productvariants.colors.create');
    }

public function storeColor(Request $request)
{
    $request->validate([
        'name' => 'required|string|min:2|max:100',
    ], [
        'name.required' => 'Vui lòng nhập tên.',
        'name.string'   => 'Tên phải là chuỗi ký tự.',
        'name.min'      => 'Tên phải có ít nhất 2 ký tự.',
        'name.max'      => 'Tên không được vượt quá 100 ký tự.',
    ]);

    $exists = Size::whereRaw('LOWER(name) = ?', [strtolower($request->name)])->exists();

    if ($exists) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Tên màu đã tồn tại.');
    }

    Color::create([
        'name' => $request->name,
    ]);

    return redirect()
        ->route('admin.products.indexVariant')
        ->with('success', 'Thêm biến thể màu mới thành công!');
}

    public function editColor($id)
{
    $item = Color::findOrFail($id);
    return view('admin.products.productvariants.edit', [
        'item' => $item,
        'type' => 'color',
    ]);
}

public function updateColor(Request $request, $id)
{
    $request->validate(['name' => 'required|string|max:255']);
    $color = Color::findOrFail($id);
    $color->update(['name' => $request->name]);
    return redirect()->route('admin.products.indexVariant')->with('success', 'Cập nhật màu sắc thành công!');
}

public function deleteColor($id)
{
    $color = Color::findOrFail($id);

    $hasProduct = ProductVariant::where('color_id', $id)->exists();

    if ($hasProduct) {
        return redirect()->route('admin.products.indexVariant')->with('error', 'Không thể xoá màu sắc vì đang được sử dụng trong sản phẩm hoặc đơn hàng.');
    }

    $color->delete();
    return redirect()->route('admin.products.indexVariant')->with('success', 'Xoá màu sắc thành công!');
}

    public function filter(Request $request)
    {
        $query = Product::with(['category', 'brand']) // Eager load để dùng ở view
            ->withSum('variants as total_stock', 'stock') // Tổng số lượng cho hiển thị
            ->orderBy('created_at', 'desc');

        // Lọc sản phẩm có ít nhất 1 biến thể < 5
        if ($request->has('low_stock') && $request->low_stock) {
            $query->whereHas('variants', function ($q) {
                $q->where('stock', '<', 5);
            });
        }

        $listProducts = $query->paginate(10);

        return view('admin.products.index', compact('listProducts'));
    }




}
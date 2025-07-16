<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $banners = Banner::latest()->paginate(10);
    return view('admin.banners.index', compact('banners'));
}

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    return view('admin.banners.create');
}

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'link'        => 'nullable|url|max:255',
        'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        'status'      => 'required|in:hidden,visible',
        'position'    => 'nullable|string|max:50',
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('banners', 'public');
        $validated['image'] = $imagePath;
    }

    // Lưu dữ liệu
    Banner::create($validated);

    return redirect()->route('admin.banners.index')->with('success', 'Thêm banner thành công!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit(string $id)
{
    $banner = Banner::findOrFail($id);
    return view('admin.banners.edit', compact('banner'));
}

public function update(Request $request, string $id)
{
    $banner = Banner::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'link' => 'nullable|url|max:255',
        'status' => 'required|in:visible,hidden',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        if ($banner->image && Storage::exists('public/' . $banner->image)) {
            Storage::delete('public/' . $banner->image);
        }

        $path = $request->file('image')->store('banners', 'public');
        $validated['image'] = $path;
    }

    $banner->update($validated);

    return redirect()->route('admin.banners.index')->with('success', 'Cập nhật banner thành công!');
}

public function destroy(string $id)
{
    $banner = Banner::findOrFail($id);

    if ($banner->status === 'visible') {
        return back()->with('error', 'Không thể xóa banner đang hiển thị. Vui lòng ẩn trước khi xóa.');
    }

    if ($banner->image && Storage::exists('public/' . $banner->image)) {
        Storage::delete('public/' . $banner->image);
    }

    $banner->delete();

    return redirect()->route('admin.banners.index')->with('success', 'Xóa banner thành công!');
}

public function toggleStatus(Request $request, $id)
{
    $banner = Banner::findOrFail($id);

    $request->validate([
        'status' => ['required', Rule::in(['visible', 'hidden'])],
    ]);

    if ($request->status === 'visible') {
        $visibleCount = Banner::where('status', 'visible')->count();
        if ($visibleCount >= 5 && $banner->status !== 'visible') {
            return back()->with('error', 'Chỉ được phép hiển thị tối đa 5 banner.');
        }
    }

    $banner->status = $request->status;
    $banner->save();

    return back()->with('success', 'Cập nhật trạng thái banner thành công!');
}



}
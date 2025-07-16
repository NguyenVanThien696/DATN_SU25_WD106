<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

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

    // Xử lý lưu ảnh vào storage
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
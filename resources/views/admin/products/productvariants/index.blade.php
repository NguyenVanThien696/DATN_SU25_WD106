@extends('admin.layouts.default')

@section('title', 'Quản lý biến thể sản phẩm')

@section('content')

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('warning'))
<div class="alert alert-warning">{{ session('warning') }}</div>
@endif
<div class="container mt-4">
    <div class="row">

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary"><i class="bi bi-palette me-2"></i>Biến thể màu sắc</h5>
                    <a href="{{ route('admin.products.createColor') }}" class="btn btn-sm btn-outline-primary"><i
                            class="bi bi-plus-circle"></i> Thêm màu</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($colors as $color)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-dark fw-semibold">{{ $color->name }}</span>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.products.editColor', $color->id) }}"
                                    class="btn btn-sm btn-light border">
                                    <i class="bi bi-pencil-square"></i>
                                    Sửa</a>
                                <form action="{{ route('admin.products.deleteColor', $color->id) }}" method="POST"
                                    onsubmit="return confirm('Xác nhận xoá màu này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border">
                                        <i class="bi bi-trash text-danger"></i>
                                        Xóa</button>
                                </form>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item text-muted text-center py-4">Chưa có màu sắc nào.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-success"><i class="bi bi-aspect-ratio me-2"></i>Biến thể kích cỡ</h5>
                    <a href="{{ route('admin.products.createSize') }}" class="btn btn-sm btn-outline-success"><i
                            class="bi bi-plus-circle"></i> Thêm kích cỡ</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($sizes as $size)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-dark fw-semibold">{{ $size->name }}</span>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.products.editSize', $size->id) }}"
                                    class="btn btn-sm btn-light border">
                                    <i class="bi bi-pencil-square"></i>
                                    Sửa</a>
                                <form action="{{ route('admin.products.deleteSize', $size->id) }}" method="POST"
                                    onsubmit="return confirm('Xác nhận xoá kích cỡ này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border">
                                        <i class="bi bi-trash text-danger"></i>
                                        Xóa</button>
                                </form>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item text-muted text-center py-4">Chưa có kích cỡ nào.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
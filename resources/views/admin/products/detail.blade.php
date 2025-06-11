@extends('admin.layouts.default')

@section('content')
<div class="p-4" style="min-height: 800px;">
    <h4 class="text-primary mb-4">Chi tiết sản phẩm</h4>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                    class="img-fluid rounded shadow">
                @else
                <p>Không có ảnh sản phẩm.</p>
                @endif
            </div>

            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th>Tên sản phẩm</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Mô tả</th>
                        <td>{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <th>Giá</th>
                        <td>{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>
                    </tr>
                    <tr>
                        <th>Danh mục</th>
                        <td>{{ $product->category->name ?? 'Không có' }}</td>
                    </tr>
                    <tr>
                        <th>Thương hiệu</th>
                        <td>{{ $product->brand->name ?? 'Không có' }}</td>
                    </tr>
                    <tr>
                        <th>Tags</th>
                        <td>{{ $product->tag->name ?? 'Không có' }}</td>
                    </tr>
                </table>

                {{-- Danh sách biến thể --}}
                <h5 class="mt-4 text-success">Biến thể sản phẩm</h5>
                @if ($product->variants->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Size</th>
                            <th>Màu sắc</th>
                            <th>Số lượng</th>
                            <th>Ảnh biến thể</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->variants as $variant)
                        <tr>
                            <td>{{ $variant->size->name ?? '---' }}</td>
                            <td>{{ $variant->color->name ?? '---' }}</td>
                            <td>{{ $variant->stock }}</td>
                            <td>
                                @if ($variant->image)
                                <img src="{{ asset('storage/' . $variant->image) }}" alt="Ảnh biến thể" width="80"
                                    class="rounded shadow">
                                @else
                                Không có ảnh
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p>Không có biến thể nào.</p>
                @endif

                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
                <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}" class="btn btn-primary">Sửa</a>
            </div>
        </div>
    </div>
</div>
@endsection
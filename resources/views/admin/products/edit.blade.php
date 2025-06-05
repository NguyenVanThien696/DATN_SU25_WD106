@extends('admin.layouts.default')

@section('content')
<div class="p-4" style="min-height: 800px;">
    <h4 class="text-primary mb-4">Cập nhật sản phẩm</h4>
    <div class="container mt-5">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('admin.products.update', ['id' => $product->id]) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" required
                    value="{{ old('name', $product->name)}}">
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description"
                    rows="3">{{ old('description', $product->description) }}</textarea>
                @error('description')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" required
                    value="{{ old('price', $product->price) }}">
                @error('price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Số lượng </label>
                <input type="number" class="form-control" id="quantity" name="quantity" rows="3"
                    value="{{ old('quantity', $product->quantity) }}">
                @error('quantity')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh sản phẩm</label>
                @if (!empty($product->image))
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Ảnh sản phẩm" width="150">
                </div>
                @endif

                <input type="file" class="form-control" id="image" name="image">
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach ($category as $value)
                    <option value="{{ $value->id }}"
                        {{ old('category_id', $product->category_id) == $value->id ? 'selected' : '' }}>
                        {{ $value->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Thương hiệu </label>
                <select name="brand_id" id="brand_id" class="form-control">
                    @foreach ($brand as $value)
                    <option value="{{ $value->id }}"
                        {{ old('brand_id', $product->brand_id) == $value->id ? 'selected' : '' }}>
                        {{ $value->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật </button>
        </form>
    </div>
</div>
@endsection
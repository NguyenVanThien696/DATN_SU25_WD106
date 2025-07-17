@extends('admin.layouts.default')

@section('content')
<div class="p-4">
    <h4 class="text-primary mb-4">Thêm Banner</h4>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-white p-4 rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label class="form-label">Tiêu đề Banner <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                value="{{ old('title') }}">
            @error('title')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả chi tiết</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                rows="3">{{ old('description') }}</textarea>
            @error('description')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Liên kết (URL)</label>
            <input type="url" class="form-control @error('link') is-invalid @enderror" name="link"
                value="{{ old('link') }}">
            @error('link')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Hình ảnh Banner <span class="text-danger">*</span></label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
            @error('image')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror">
                <option value="" disabled selected>-- Chọn trạng thái --</option>
                <option value="visible" {{ old('status') == 'visible' ? 'selected' : '' }}>Hiển thị</option>
                <option value="hidden" {{ old('status') == 'hidden' ? 'selected' : '' }}>Ẩn</option>
            </select>
            @error('status')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Lưu Banner</button>
        </div>
    </form>
</div>
@endsection
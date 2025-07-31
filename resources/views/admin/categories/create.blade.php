    @extends('admin.layouts.default')

    @section('content')
    <div class="p-4">
        <h4 class="text-primary mb-4">Thêm danh mục</h4>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tên danh mục</label>
                <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" name="description" rows="3" value="{{ old('description') }}"></textarea>
            </div>

            <button class="btn btn-success mt-3"><i class="fas fa-save me-1"></i> Lưu</button>
        </form>
    </div>

    @endsection
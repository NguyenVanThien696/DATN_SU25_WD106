    @extends('admin.layouts.default')

    @section('content')
    <div class="p-4">
        <h4 class="text-primary mb-4">Thêm biến thể màu sắc</h4>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.products.storeColor') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tên màu sắc</label>
                <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
            </div>

            <button type="submit" class="btn btn-primary">Thêm màu sắc</button>
        </form>
    </div>

    @endsection
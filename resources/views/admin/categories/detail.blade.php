@extends('admin.layouts.default')

@section('content')
<div class="p-4" style="min-height: 800px;">
    <h4 class="text-primary mb-4">Chi tiết danh mục</h4>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th>Tên danh mục</th>
                        <td>{{ $category->name }}</td>
                    </tr>
                    <tr>
                        <th>Mô tả</th>
                        <td>{{ $category->description }}</td>
                    </tr>
                </table>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
                <a href="{{ route('admin.categories.edit', ['id' => $category->id]) }}" class="btn btn-primary">Sửa</a>
            </div>
        </div>
    </div>
</div>
@endsection

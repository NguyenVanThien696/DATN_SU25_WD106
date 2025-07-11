@extends('admin.layouts.default')

@section('title', 'Danh sách sản phẩm')

@section('content')
    <main class="h-full">
        <div class="page-container relative h-full flex flex-auto flex-col px-4 sm:px-6 md:px-8 py-4 sm:py-6">
            <div class="container mx-auto">
                <div class="card adaptable-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="mb-0" style="
                                            font-size: 1.75rem;
                                            font-weight: 700;
                                            color: #343a40;
                                            border-left: 5px solid #0d6efd;
                                            padding-left: 12px;
                                            margin-bottom: 1rem;
                                            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                        ">
                                Danh sách sản phẩm
                            </h3>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ Thêm mới</a>
                        </div>

                        {{-- Flash messages --}}
                        @foreach (['success', 'error', 'warning'] as $msg)
                            @if (session($msg))
                                <div class="alert alert-{{ $msg }}">{{ session($msg) }}</div>
                            @endif
                        @endforeach

                        <div class="table-responsive">
                            <table class="table table-striped table-hover text-nowrap"
                                style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6;">
                                <thead>
                                    <tr style="background-color: #f8f9fa;">
                                        <th
                                            style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                            ID</th>
                                        <th
                                            style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                            Tên sản phẩm</th>
                                        <th
                                            style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                            Ảnh</th>
                                        <th
                                            style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                            Danh mục</th>
                                        <th
                                            style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                            Thương hiệu</th>
                                        <th
                                            style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                            Tồn kho</th>
                                        <th
                                            style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                            Giá</th>
                                        <th
                                            style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                            Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listProducts as $product)
                                        <tr>
                                            <td
                                                style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                                {{ $product->id }}
                                            </td>
                                            <td style="vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                                {{ $product->name }}
                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                                @if ($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Ảnh sản phẩm"
                                                        style="width: 64px; height: 64px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc;">
                                                @else
                                                    <span class="text-muted">Không có</span>
                                                @endif
                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                                {{ $product->category->name ?? 'N/A' }}
                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                                {{ $product->brand->name ?? 'N/A' }}
                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                                {{ $product->total_stock ?? 0 }}
                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                                {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #dee2e6;">
                                                <a href="{{ route('admin.products.show', $product->id) }}"
                                                    class="btn btn-sm btn-outline-secondary" title="Xem" style="margin: 2px;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                                    class="btn btn-sm btn-outline-warning" title="Sửa" style="margin: 2px;">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.products.delete', $product->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" title="Xóa"
                                                        style="margin: 2px;"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Pagination --}}
                        <div class="mt-4 d-flex justify-content-end" style="gap: 0.5rem;">
                            <style>
                                .pagination {
                                    gap: 0.5rem;
                                }

                                .page-item {
                                    border-radius: 0.375rem;
                                    overflow: hidden;
                                }

                                .page-item .page-link {
                                    color: #333;
                                    border: 1px solid #dee2e6;
                                    padding: 0.5rem 0.9rem;
                                    border-radius: 0.375rem;
                                    transition: all 0.2s ease-in-out;
                                    font-weight: 500;
                                    font-size: 0.95rem;
                                }

                                .page-item.active .page-link {
                                    background-color: #0d6efd;
                                    color: #fff;
                                    border-color: #0d6efd;
                                    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
                                }

                                .page-item .page-link:hover {
                                    background-color: #e9ecef;
                                    color: #0d6efd;
                                    border-color: #adb5bd;
                                }
                            </style>

                            {{ $listProducts->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
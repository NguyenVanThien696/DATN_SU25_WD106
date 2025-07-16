@extends('admin.layouts.default')

@section('title', 'Danh sách banner')

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
                            Danh sách banner
                        </h3>
                        <a href="{{ route('admin.banners.create') }}" class="btn btn-success">+ Thêm mới</a>
                    </div>

                    {{-- Flash messages --}}
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-nowrap"
                            style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6;">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">ID</th>
                                    <th style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">Tiêu đề
                                    </th>
                                    <th style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">Ảnh</th>
                                    <th style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">Vị trí
                                    </th>
                                    <th style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">Trạng thái
                                    </th>
                                    <th style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banners as $banner)
                                <tr>
                                    <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">
                                        {{ $banner->id }}
                                    </td>
                                    <td style="padding: 10px; border: 1px solid #dee2e6;">
                                        {{ $banner->title }}
                                    </td>
                                    <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">
                                        @if ($banner->image)
                                        <img src="{{ asset('storage/' . $banner->image) }}"
                                            style="width: 100px; height: auto; border-radius: 5px;">
                                        @else
                                        <span class="text-muted">Không có</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">
                                        {{ $banner->position ?? 'Không xác định' }}
                                    </td>
                                    <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-sm dropdown-toggle {{ $banner->status === 'visible' ? 'btn-success' : 'btn-secondary' }}"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $banner->status === 'visible' ? 'Hiển thị' : 'Ẩn' }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach (['visible' => 'Hiển thị', 'hidden' => 'Ẩn'] as $value =>
                                                $label)
                                                @if ($value !== $banner->status)
                                                <li>
                                                    <form
                                                        action="{{ route('admin.banners.toggleStatus', $banner->id) }}"
                                                        method="POST" class="px-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ $value }}">
                                                        <button type="submit" class="dropdown-item btn-link">
                                                            {{ $label }}
                                                        </button>
                                                    </form>
                                                </li>
                                                @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </td>


                                    <td style="text-align: center; padding: 10px; border: 1px solid #dee2e6;">
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa banner này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        {{ $banners->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
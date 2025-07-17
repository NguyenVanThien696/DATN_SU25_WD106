@extends('admin.layouts.default')

@section('title', 'Sửa ' . ($type === 'color' ? 'Màu sắc' : 'Kích cỡ'))

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8"> 
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 text-dark">
                        <i class="bi {{ $type === 'color' ? 'bi-palette' : 'bi-aspect-ratio' }} me-2"></i>
                        Sửa {{ $type === 'color' ? 'màu sắc' : 'kích cỡ' }}
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ $type === 'color'
                            ? route('admin.products.updateColor', $item->id)
                            : route('admin.products.updateSize', $item->id)
                        }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên {{ $type === 'color' ? 'màu' : 'kích cỡ' }}</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $item->name) }}" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ $type === 'color'
                                    ? route('admin.products.indexVariant') . '#color'
                                    : route('admin.products.indexVariant') . '#size'
                                }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                            <button class="btn btn-success mt-3"><i class="fas fa-save me-1"></i>Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

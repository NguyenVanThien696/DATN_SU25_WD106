@extends('admin.layouts.default')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>Thêm Voucher Mới</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.vouchers.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mã giảm giá</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                        @error('code') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Loại giảm giá</label>
                        <select name="discount_type" id="discount_type" class="form-select">
                            <option value="">-- Chọn loại --</option>
                            <option value="percent" {{ old('discount_type') === 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                            <option value="amount" {{ old('discount_type') === 'amount' ? 'selected' : '' }}>Số tiền (VNĐ)</option>
                        </select>
                        @error('discount_type') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>


                <div class="row d-none" id="discount_percent_group">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phần trăm giảm (%)</label>
                        <div class="input-group">
                            <input type="number" name="discount_percent" class="form-control" value="{{ old('discount_percent') }}">
                            <span class="input-group-text">%</span>
                        </div>
                        @error('discount_percent') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mb-3" id="max_discount_group">
                        <label class="form-label">Số tiền giảm tối đa (VNĐ)</label>
                        <div class="input-group">
                            <input type="number" name="max_discount_amount" class="form-control" value="{{ old('max_discount_amount') }}">
                            <span class="input-group-text">VNĐ</span>
                        </div>
                        @error('max_discount_amount') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>


                <div class="row d-none" id="discount_amount_group">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số tiền giảm (VNĐ)</label>
                        <div class="input-group">
                            <input type="number" name="discount_amount" class="form-control" value="{{ old('discount_amount') }}">
                            <span class="input-group-text">VNĐ</span>
                        </div>
                        @error('discount_amount') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số lượt sử dụng tối đa</label>
                        <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit') }}">
                        @error('usage_limit') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tạm ngưng</option>
                            <option value="expired" {{ old('status') === 'expired' ? 'selected' : '' }}>Hết hạn</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Thời gian bắt đầu</label>
                        <input type="datetime-local" name="start_at" class="form-control" value="{{ old('start_at') }}">
                        @error('start_at') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Thời gian kết thúc</label>
                        <input type="datetime-local" name="end_at" class="form-control" value="{{ old('end_at') }}">
                        @error('end_at') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-success"><i class="fas fa-save me-1"></i> Lưu</button>
                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleDiscountFields() {
        const type = document.getElementById('discount_type').value;
        const percentGroup = document.getElementById('discount_percent_group');
        const maxDiscountGroup = document.getElementById('max_discount_group');
        const amountGroup = document.getElementById('discount_amount_group');

        percentGroup.classList.add('d-none');
        maxDiscountGroup.classList.add('d-none');
        amountGroup.classList.add('d-none');

        if (type === 'percent') {
            percentGroup.classList.remove('d-none');
            maxDiscountGroup.classList.remove('d-none');
        } else if (type === 'amount') {
            amountGroup.classList.remove('d-none');
        }
    }

    document.addEventListener('DOMContentLoaded', toggleDiscountFields);
    document.getElementById('discount_type').addEventListener('change', toggleDiscountFields);
</script>
@endpush

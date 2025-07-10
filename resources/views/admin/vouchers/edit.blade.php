@extends('admin.layouts.default')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="mb-4 text-primary"><i class="fas fa-edit me-2"></i>Cập nhật Voucher</h4>

            <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mã giảm giá</label>
                    <input type="text" name="code" class="form-control rounded-pill"
                        value="{{ old('code', $voucher->code) }}">
                    @error('code') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Loại giảm giá</label>
                    <select name="discount_type" id="discount_type" class="form-select rounded-pill">
                        <option value="percent"
                            {{ old('discount_type', $voucher->discount_type) === 'percent' ? 'selected' : '' }}>Phần
                            trăm (%)</option>
                        <option value="amount"
                            {{ old('discount_type', $voucher->discount_type) === 'amount' ? 'selected' : '' }}>Số tiền
                            (VNĐ)</option>
                    </select>
                    @error('discount_type') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3" id="discount_percent_group">
                    <label class="form-label fw-semibold">Phần trăm giảm (%)</label>
                    <input type="number" name="discount_percent" class="form-control rounded-pill"
                        value="{{ old('discount_percent', $voucher->discount_percent) }}">
                </div>

                <div class="mb-3" id="discount_amount_group">
                    <label class="form-label fw-semibold">Số tiền giảm (VNĐ)</label>
                    <input type="number" name="discount_amount" class="form-control rounded-pill"
                        value="{{ old('discount_amount', $voucher->discount_amount) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Số lượt sử dụng tối đa</label>
                    <input type="number" name="usage_limit" class="form-control rounded-pill"
                        value="{{ old('usage_limit', $voucher->usage_limit) }}">
                    @error('usage_limit') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Thời gian bắt đầu</label>
                    <input type="datetime-local" name="start_at" class="form-control rounded-pill"
                        value="{{ old('start_at', $voucher->start_at ? \Carbon\Carbon::parse($voucher->start_at)->format('Y-m-d\TH:i') : '') }}">
                    @error('start_at') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Thời gian kết thúc</label>
                    <input type="datetime-local" name="end_at" class="form-control rounded-pill"
                        value="{{ old('end_at', $voucher->end_at ? \Carbon\Carbon::parse($voucher->end_at)->format('Y-m-d\TH:i') : '') }}">
                    @error('end_at') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Trạng thái</label>
                    <select name="status" class="form-select rounded-pill">
                        <option value="active" {{ old('status', $voucher->status) === 'active' ? 'selected' : '' }}>Đang
                            hoạt động</option>
                        <option value="inactive" {{ old('status', $voucher->status) === 'inactive' ? 'selected' : '' }}>
                            Tạm ngưng</option>
                        <option value="expired" {{ old('status', $voucher->status) === 'expired' ? 'selected' : '' }}>
                            Hết hạn</option>
                    </select>
                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-save me-1"></i> Cập nhật
                    </button>
                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleDiscountFields() {
    const type = document.getElementById('discount_type').value;
    const percentGroup = document.getElementById('discount_percent_group');
    const amountGroup = document.getElementById('discount_amount_group');

    if (type === 'percent') {
        percentGroup.style.display = 'block';
        amountGroup.style.display = 'none';
    } else if (type === 'amount') {
        percentGroup.style.display = 'none';
        amountGroup.style.display = 'block';
    } else {
        percentGroup.style.display = 'none';
        amountGroup.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const discountType = document.getElementById('discount_type');
    discountType.addEventListener('change', toggleDiscountFields);
    toggleDiscountFields(); // Gọi lần đầu khi trang load
});
</script>
@endpush

@endsection
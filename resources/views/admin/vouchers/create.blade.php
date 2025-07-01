@extends('admin.layouts.default')

@section('content')
<div class="container mt-4">
    <h2>Thêm Voucher Mới</h2>

    <form action="{{ route('admin.vouchers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Mã giảm giá</label>
            <input type="text" name="code" class="form-control" value="{{ old('code') }}">
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Loại giảm giá</label>
            <select name="discount_type" id="discount_type" class="form-control">
                <option value="percent" {{ old('discount_type') === 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                <option value="amount" {{ old('discount_type') === 'amount' ? 'selected' : '' }}>Số tiền (VNĐ)</option>
            </select>
            @error('discount_type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3" id="discount_percent_group">
            <label>Phần trăm giảm (%)</label>
            <input type="number" name="discount_percent" class="form-control" value="{{ old('discount_percent') }}">
            @error('discount_percent') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3" id="discount_amount_group">
            <label>Số tiền giảm (VNĐ)</label>
            <input type="number" name="discount_amount" class="form-control" value="{{ old('discount_amount') }}">
            @error('discount_amount') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Số lượt sử dụng tối đa</label>
            <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit') }}">
            @error('usage_limit') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Thời gian bắt đầu</label>
            <input type="datetime-local" name="start_at" class="form-control" value="{{ old('start_at') }}">
            @error('start_at') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Thời gian kết thúc</label>
            <input type="datetime-local" name="end_at" class="form-control" value="{{ old('end_at') }}">
            @error('end_at') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-control">
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tạm ngưng</option>
                <option value="expired" {{ old('status') === 'expired' ? 'selected' : '' }}>Hết hạn</option>
            </select>
            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

{{-- JavaScript để ẩn/hiện input tương ứng --}}
@push('scripts')
<script>
    function toggleDiscountFields() {
        const type = document.getElementById('discount_type').value;
        document.getElementById('discount_percent_group').style.display = (type === 'percent') ? 'block' : 'none';
        document.getElementById('discount_amount_group').style.display = (type === 'amount') ? 'block' : 'none';
    }

    document.getElementById('discount_type').addEventListener('change', toggleDiscountFields);
    toggleDiscountFields();
</script>
@endpush
@endsection

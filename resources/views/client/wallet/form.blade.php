@extends('client.master')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">Yêu cầu trả hàng / hoàn tiền - Mã đơn: #{{ $order->id }}</h4>

<form action="{{ route('client.wallet.refund.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->id }}">

    {{-- Lý do trả hàng --}}
    <div class="mb-3">
        <label for="reason" class="form-label">Lý do trả hàng <span class="text-danger">*</span></label>
        <textarea name="reason" id="reason" rows="4" class="form-control" required>{{ old('reason') }}</textarea>
        @error('reason')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Hình ảnh minh chứng --}}
    <div class="mb-3">
        <label for="image" class="form-label">Hình ảnh minh chứng <span class="text-danger">*</span></label>
        <input type="file" name="image" id="image" accept="image/*" class="form-control" required>
        @error('image')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Thông tin tài khoản hoàn tiền --}}
    <h5 class="mt-4">Thông tin tài khoản nhận hoàn tiền</h5>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="original_bank_name" class="form-label">Ngân hàng <span class="text-danger">*</span></label>
            <input type="text" name="original_bank_name" id="original_bank_name" class="form-control" required value="{{ old('original_bank_name') }}">
            @error('original_bank_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="original_account_number" class="form-label">Số tài khoản <span class="text-danger">*</span></label>
            <input type="text" name="original_account_number" id="original_account_number" class="form-control" required value="{{ old('original_account_number') }}">
            @error('original_account_number')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="original_account_name" class="form-label">Tên chủ tài khoản <span class="text-danger">*</span></label>
            <input type="text" name="original_account_name" id="original_account_name" class="form-control" required value="{{ old('original_account_name') }}">
            @error('original_account_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    {{-- Submit --}}
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
        <a href="{{ route('client.order.detail', $order->id) }}" class="btn btn-secondary">Quay lại đơn hàng</a>
    </div>
</form>

</div>
@endsection

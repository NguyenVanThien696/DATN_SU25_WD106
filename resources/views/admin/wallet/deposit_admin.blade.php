@extends('admin.layouts.default')

@section('content')

<div class="container py-4 max-w-xl mx-auto">
    <h2 class="mb-4 text-xl font-semibold">Nạp tiền vào ví (Admin)</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('admin.wallet.deposit.admin.redirect') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="amount" class="form-label">Số tiền cần nạp <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount" class="form-control" placeholder="Nhập số tiền (VND)"
                value="{{ old('amount') }}">
            @error('amount')
            <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả giao dịch (không bắt buộc)</label>
            <input type="text" name="description" id="description" class="form-control"
                value="{{ old('description') }}">
            @error('description')
            <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>


        <button class="btn btn-success mt-3"><i class="fas fa-save me-1"></i> Nạp tiền bằng VNPAY (Demo)</button>
    </form>
</div>
@endsection
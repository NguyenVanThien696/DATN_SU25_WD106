@extends('client.master')

@section('content')
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container my-5">
    <div class="d-flex justify-content-center">
        <form action="{{ route('client.wallet.withdraw.store') }}" method="POST"
            class="p-4 border rounded shadow-sm bg-light" style="max-width: 700px; width: 100%;">
            @csrf

            <div class="mb-3">
                <label for="amount" class="form-label">Số tiền muốn rút</label>
                <input type="number" name="amount" id="amount" class="form-control"
                    placeholder="Nhập số tiền">
                @error('amount')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="account_number" class="form-label">Số tài khoản</label>
                <input type="text" name="account_number" id="account_number" class="form-control"
                    value="{{ $bank_info->account_number ?? '' }}" placeholder="Nhập số tài khoản">
                @error('account_number')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="bank_name" class="form-label">Tên ngân hàng</label>
                <input type="text" name="bank_name" id="bank_name" class="form-control"
                    value="{{ $bank_info->bank_name ?? '' }}" placeholder="Nhập tên ngân hàng">
                @error('bank_name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="account_name" class="form-label">Tên chủ tài khoản</label>
                <input type="text" name="account_name" id="account_name" class="form-control"
                    value="{{ $bank_info->account_name ?? '' }}" placeholder="Nhập tên chủ tài khoản">
                @error('account_name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nhập mật khẩu để xác nhận</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu">
                @error('password')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Rút tiền</button>
        </form>
    </div>
</div>
@endsection
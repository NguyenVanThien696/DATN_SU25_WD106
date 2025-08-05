@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <h2>Nạp tiền vào ví admin</h2>

    <form action="{{ route('admin.wallet.deposit.admin.redirect') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="amount" class="form-label">Số tiền cần nạp</label>
            <input type="number" name="amount" id="amount" class="form-control" min="1000" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả (tuỳ chọn)</label>
            <input type="text" name="description" id="description" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Nạp tiền qua VNPay</button>
    </form>
</div>
@endsection

@extends('client.master')

@section('content')
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="container py-5" style="max-width: 700px;">
    <h3 class="mb-4">Ví cá nhân của bạn</h3>

    <div class="card mb-4">
        <div class="card-body text-center">
            <h5>Số dư hiện tại</h5>
            <p class="display-4 text-primary">
                {{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }} đ
            </p>

            <a href="{{ route('client.wallet.deposit') }}" class="btn btn-success me-2">Nạp tiền</a>
            <a href="{{ route('client.wallet.withdraw') }}" class="btn btn-warning">Rút tiền</a>
        </div>
    </div>

    <h5>Lịch sử giao dịch</h5>
    @if ($transactions->count() > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Thời gian</th>
                <th>Loại giao dịch</th>
                <th>Số tiền</th>
                <th>Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $txn)
            <tr>
                <td>{{ $txn->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    @php
                    $type = $txn->type;
                    $badge = [
                    'deposit' => 'success',
                    'withdraw' => 'danger',
                    'refund_out' => 'info',
                    'refund_in' => 'info',
                    ][$type] ?? 'secondary';

                    $label = [
                    'deposit' => 'Nạp tiền',
                    'withdraw' => 'Rút tiền',
                    'refund_out' => 'Hoàn tiền',
                    'refund_in' => 'Hoàn tiền',
                    ][$type] ?? ucfirst($type);
                    @endphp
                    <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                </td>
                <td class="{{ $txn->amount > 0 ? 'text-success' : 'text-danger' }}">
                    {{ number_format($txn->amount, 0, ',', '.') }} đ
                </td>
                <td>{{ $txn->note ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Chưa có giao dịch nào.</p>
    @endif
</div>
@endsection
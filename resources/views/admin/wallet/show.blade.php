@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2 rounded">
            <li class="breadcrumb-item"><a href="{{ route('admin.wallet.transactions.index') }}">Quản lý ví</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lịch sử giao dịch: {{ $user->name }}</li>
        </ol>
    </nav>

    <div class="mb-4 p-4 border rounded bg-light shadow-sm">
        <h4 class="mb-2">👤 {{ $user->name }} <small class="text-muted">({{ $user->email }})</small></h4>
        <p class="mb-0">
            Số dư hiện tại:
            <strong class="text-success fs-5">{{ number_format($user->wallet->balance ?? 0) }} đ</strong>
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="fa-solid fa-clock-rotate-left me-2"></i> Lịch sử giao dịch
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Loại</th>
                        <th>Số tiền</th>
                        <th>Mô tả</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($user->walletTransactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @php
                                    $type = $transaction->type;
                                    $badge = [
                                        'deposit' => 'success',
                                        'withdraw' => 'danger',
                                        'refund' => 'info',
                                    ][$type] ?? 'secondary';

                                    $label = [
                                        'deposit' => 'Nạp tiền',
                                        'withdraw' => 'Rút tiền',
                                        'refund' => 'Hoàn tiền',
                                    ][$type] ?? ucfirst($type);
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                            </td>
                            <td>{{ number_format($transaction->amount) }} đ</td>
                            <td>{{ $transaction->description }}</td>
                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fa-solid fa-circle-exclamation me-2"></i>
                                Không có giao dịch nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

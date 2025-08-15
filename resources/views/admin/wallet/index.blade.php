@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
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
    <h2 class="mb-4">Quản lý ví người dùng</h2>

    @if ($admin && $admin->wallet)
    <div class="border rounded mb-5 shadow-sm border-warning">
        <div class="p-3 bg-warning bg-opacity-10 d-flex justify-between items-center">
            <div>
                <h5 class="mb-1">💼 Ví của Admin</h5>
                <p class="mb-1">
                    <strong>{{ $admin->name }}</strong> – {{ $admin->email }}
                </p>
                <p class="text-muted mb-0">
                    Số dư hiện tại:
                    <strong class="text-success">{{ number_format($admin->wallet->balance) }} đ</strong>
                </p>
            </div>
            <div>
                <a href="{{ route('admin.wallet.transactions.user', $admin->id) }}" class="btn btn-sm btn-primary">
                    Xem chi tiết
                </a>

                <a href="{{ route('admin.wallet.deposit.admin.form') }}" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-circle-plus me-1"></i> Nạp tiền
                </a>
            </div>
        </div>
    </div>
    @endif

    @forelse ($users as $user)
    <div class="border rounded mb-5 shadow-sm">
        <div class="p-3 bg-light d-flex justify-between items-center">
            <div>
                <strong>{{ $user->name }}</strong> – {{ $user->email }}<br>
                <span class="text-muted">Số dư:
                    <strong class="text-success">{{ number_format($user->wallet->balance ?? 0) }} đ</strong>
                </span>
            </div>
            <div>
                <a href="{{ route('admin.wallet.transactions.user', $user->id) }}" class="btn btn-sm btn-primary">
                    Xem chi tiết
                </a>
            </div>
        </div>

        <div class="p-3">
            @if ($user->walletTransactions->isEmpty())
            <p class="text-muted mb-0">Chưa có giao dịch ví nào.</p>
            @else
            <table class="table table-sm table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Loại</th>
                        <th>Số tiền</th>
                        <th>Mô tả</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->walletTransactions as $trx)
                    <tr>
                        <td>{{ $trx->id }}</td>
                        <td>
                            @php
                            $type = $trx->type;
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
                        <td>{{ number_format($trx->amount) }} đ</td>
                        <td>{{ $trx->description }}</td>
                        <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
    @empty
    <p class="text-muted">Không có người dùng nào có ví.</p>
    @endforelse
</div>
@endsection
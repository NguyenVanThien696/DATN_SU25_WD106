@extends('admin.layouts.default')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header text-dark fw-semibold" style="background-color: #e6f4ea;">
            <h1 class="mb-0 h4 d-flex align-items-center">
                <i class="bi bi-arrow-counterclockwise me-2 text-success fs-4"></i> Yêu cầu hoàn tiền
            </h1>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($refundRequests->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                    <h5 class="fw-semibold">Không có yêu cầu hoàn tiền nào.</h5>
                </div>
            @else
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>SĐT</th>
                                <th>Tổng tiền</th>
                                <th>Ngày yêu cầu</th>
                                <th>Lý do</th>
                                <th>Trạng thái</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($refundRequests as $refund)
                                @php
                                    $statusLabel = [
                                        'pending' => ['label' => 'Chờ xử lý', 'class' => 'bg-warning text-dark'],
                                        'approved' => ['label' => 'Đã hoàn tiền', 'class' => 'bg-success'],
                                        'rejected' => ['label' => 'Đã từ chối', 'class' => 'bg-danger'],
                                    ][$refund->status] ?? ['label' => 'Không rõ', 'class' => 'bg-secondary'];

                                    $user = $refund->user;
                                    $order = $refund->order;
                                @endphp
                                <tr>
                                    <td>#{{ $order->order_code ?? '---' }}</td>
                                    <td title="{{ $user->name ?? '[N/A]' }}">
                                        {{ Str::limit($user->name ?? '[N/A]', 18) }}
                                        <br><small class="text-muted">{{ $user->email ?? '' }}</small>
                                    </td>
                                    <td>{{ $order->customer_phone ?? '---' }}</td>
                                    <td>{{ number_format($order->total_price ?? 0, 0, ',', '.') }}đ</td>
                                    <td>
                                        <span class="fw-bold">{{ $refund->created_at->format('H:i') }}</span><br>
                                        {{ $refund->created_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ Str::limit($refund->reason, 40) }}
                                        @if ($refund->image)
                                            <br>
                                            <a href="{{ asset('storage/' . $refund->image) }}" target="_blank" class="d-inline-block mt-1">
                                                <i class="bi bi-image-fill text-success" title="Ảnh minh chứng"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td><span class="badge {{ $statusLabel['class'] }}">{{ $statusLabel['label'] }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.wallet.refund-requests.show', $refund->id) }}"
                                           class="btn btn-sm btn-outline-dark">
                                            <i class="bi bi-eye"></i> Xem
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $refundRequests->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

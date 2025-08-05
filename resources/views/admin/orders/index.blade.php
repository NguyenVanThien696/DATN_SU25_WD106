@extends('admin.layouts.default')

@section('title', 'Admin - Đơn hàng')

@section('content')
<main class="py-5">
    <style>
    .table th,
    .table td {
        font-size: 12px;
        vertical-align: middle;
        white-space: nowrap;
        padding: 0.45rem 0.5rem;
    }

    .badge {
        font-size: 11px !important;
        padding: 0.35em 0.6em;
        border-radius: 0.35rem;
        font-weight: 500;
    }

    .btn-sm,
    .action-btn {
        font-size: 11px;
        padding: 0.25rem 0.4rem;
        line-height: 1.2;
    }

    .pagination .page-link {
        font-size: 12px;
        padding: 0.4rem 0.6rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #198754;
        border-color: #198754;
        color: #fff;
    }

    .badge-pending {
        background-color: #ffc107;
    }

    .badge-processing {
        background-color: #17a2b8;
    }

    .badge-completed {
        background-color: #28a745;
    }

    .badge-cancelled {
        background-color: #dc3545;
    }
    </style>

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header text-dark fw-semibold" style="background-color: #e6f4ea;">
                <h1 class="mb-0 h4 d-flex align-items-center">
                    <i class="bi bi-bag-check me-2 text-success fs-4"></i> Đơn hàng
                </h1>
            </div>
            <div class="card-body">
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

                @if ($orders->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-calendar-x fs-1 d-block mb-3 text-secondary"></i>
                    <h5 class="fw-semibold">Không có đơn hàng nào.</h5>
                </div>
                @else
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Khách</th>
                                <th>SĐT</th>
                                <th>Tổng</th>
                                <th>PT Thanh toán</th>
                                <th>Trạng thái đơn hàng</th>
                                <th>Trạng thái thanh toán</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            @php
                            // Ưu tiên trạng thái hoàn tiền nếu có yêu cầu
                            $status = $order->status;

                            if ($order->refundRequest) {
                            switch ($order->refundRequest->status) {
                            case 'pending':
                            $status = 'refund_pending';
                            break;
                            case 'approved':
                            $status = 'refund_approved';
                            break;
                            case 'rejected':
                            $status = 'refund_rejected';
                            break;
                            }
                            }

                            // Danh sách hiển thị tên trạng thái
                            $statusList = [
                            'pending' => 'Chờ xử lý',
                            'confirmed' => 'Đã xác nhận',
                            'processing' => 'Đang chuẩn bị',
                            'shipping' => 'Đang giao hàng',
                            'delivered' => 'Đã giao (chờ khách xác nhận)',
                            'completed' => 'Đã hoàn tất',
                            'cancelled' => 'Đã huỷ',
                            'cancelled_paid' => 'Đã hủy (chờ hoàn tiền)',
                            'refunded' => 'Đã hoàn tiền',
                            'delivery_failed' => 'Giao thất bại',
                            'refund_pending' => 'Chờ xét duyệt trả hàng / hoàn tiền',
                            'refund_rejected' => 'Từ chối trả hàng / hoàn tiền',
                            'refund_approved' => 'Đã hoàn tiền',
                            ];

                            // Badge màu sắc tương ứng
                            $statusClass = [
                            'pending' => 'bg-warning text-dark',
                            'confirmed' => 'bg-primary text-white',
                            'processing' => 'bg-info text-white',
                            'shipping' => 'bg-warning text-dark',
                            'delivered' => 'bg-secondary text-white',
                            'completed' => 'bg-success text-white',
                            'cancelled' => 'bg-danger text-white',
                            'cancelled_paid' => 'bg-warning text-dark',
                            'refunded' => 'bg-success text-white',
                            'delivery_failed' => 'bg-dark text-white',
                            'refund_pending' => 'bg-info text-white',
                            'refund_rejected' => 'bg-danger text-white',
                            'refund_approved' => 'bg-success text-white',
                            ][$status] ?? 'bg-secondary text-white';

                            // Phương thức thanh toán
                            $method = $order->payment_method;
                            $methodLabel = $method === 'cod' ? 'COD' : ($method === 'vnpay' ? 'VNPay' : '---');
                            $methodClass = $method === 'cod' ? 'bg-secondary' : ($method === 'vnpay' ? 'bg-primary' :
                            'bg-light');

                            // Trạng thái thanh toán
                            $paymentStatusHtml = $order->payment_status === 'paid'
                            ? '<span class="badge bg-success">Đã thanh toán</span>'
                            : '<span class="badge bg-warning text-dark">Thanh toán khi nhận hàng</span>';

                            if (in_array($order->status, ['refund_pending', 'refund_rejected', 'refund_approved'])) {
                            $availableTransitions = [];
                            } else {
                            // Các trạng thái có thể chuyển tiếp
                            $availableTransitions = match ($order->status) {
                            'pending' => ['confirmed', 'cancelled'],
                            'confirmed' => ['processing', 'cancelled'],
                            'processing' => ['shipping', 'cancelled'],
                            'shipping' => ['delivered', 'delivery_failed'],
                            default => [],
                            };
                            }
                            @endphp
                            <tr data-order-id="{{ $order->id }}">
                                <td>#{{ $order->order_code }}</td>
                                <td>
                                    <span class="fw-bold">{{ $order->created_at->format('H:i') }}</span><br>
                                    {{ $order->created_at->format('d/m/Y') }}
                                </td>
                                <td title="{{ $order->customer_name }}">
                                    {{ Str::limit($order->customer_name, 18) }}
                                </td>
                                <td>{{ $order->customer_phone }}</td>
                                <td><strong>{{ number_format($order->total_price, 0, ',', '.') }} đ</strong></td>
                                <td><span class="badge {{ $methodClass }} text-white">{{ $methodLabel }}</span></td>

                                <td class="order-status" data-order-id="{{ $order->id }}" data-status="{{ $status }}">
                                    @if (!empty($availableTransitions))
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle badge {{ $statusClass }}"
                                            data-bs-toggle="dropdown">
                                            {{ $statusList[$status] ?? $status }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach ($availableTransitions as $key)
                                            <li>
                                                <form action="{{ route('admin.order.updateStatus', $order->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="{{ $key }}">
                                                    <button type="submit" class="dropdown-item">
                                                        {{ $statusList[$key] ?? $key }}
                                                    </button>
                                                </form>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @else
                                    <span class="badge {{ $statusClass }}">
                                        {{ $statusList[$status] ?? $status }}
                                    </span>
                                    @endif
                                </td>

                                <td>{!! $paymentStatusHtml !!}</td>
                                <td>
                                    <a href="{{ route('admin.order.detail', $order->id) }}"
                                        class="btn btn-sm btn-outline-dark action-btn">
                                        <i class="bi bi-eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>

@endsection
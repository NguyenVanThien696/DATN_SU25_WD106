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
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                            ];
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
                                            ][$order->status] ?? 'bg-secondary text-white';

                                            $method = $order->payment_method;
                                            $methodLabel = $method === 'cod' ? 'COD' : ($method === 'vnpay' ? 'VNPay' : '---');
                                            $methodClass = $method === 'cod' ? 'bg-secondary' : ($method === 'vnpay' ? 'bg-primary' : 'bg-light');

                                            $paymentStatusHtml = $method === 'vnpay'
                                                ? '<span class="badge bg-success">Đã thanh toán</span>'
                                                : '<span class="badge bg-warning text-dark">Thanh toán khi nhận hàng</span>';

                                            $availableTransitions = match ($order->status) {
                                                'pending' => ['confirmed', 'cancelled'],
                                                'confirmed' => ['processing', 'cancelled'],
                                                'processing' => ['shipping', 'cancelled'],
                                                'shipping' => ['delivered', 'delivery_failed'],
                                                'delivered' => ['completed'],
                                                default => [],
                                            };
                                        @endphp
                                        <tr data-order-id="{{ $order->id }}">
                                            <td>#{{ $order->order_code }}</td>
                                            <td>
                                                <span class="fw-bold">{{ $order->created_at->format('H:i') }}</span><br>
                                                {{ $order->created_at->format('d/m/Y') }}
                                            </td>
                                            <td title="{{ $order->shippingAddress->name ?? $order->user->name }}">
                                                {{ Str::limit($order->shippingAddress->name ?? $order->user->name, 18) }}
                                            </td>
                                            <td>{{ $order->shippingAddress->phone ?? $order->user->phone ?? '---' }}</td>
                                            <td><strong>{{ number_format($order->total_price, 0, ',', '.') }} đ</strong></td>
                                            <td><span class="badge {{ $methodClass }} text-white">{{ $methodLabel }}</span></td>
                                            <td class="order-status" data-order-id="{{ $order->id }}"
                                                data-status="{{ $order->status }}">
                                                @if (!empty($availableTransitions))
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-sm dropdown-toggle badge {{ 'badge-' . strtolower($order->status) }}"
                                                            data-bs-toggle="dropdown">
                                                            {{ $statusList[$order->status] ?? $order->status }}
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @foreach ($availableTransitions as $key)
                                                                <li>
                                                                    <form action="{{ route('admin.order.updateStatus', $order->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="status" value="{{ $key }}">
                                                                        <button type="submit"
                                                                            class="dropdown-item">{{ $statusList[$key] }}</button>
                                                                    </form>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <span class="badge {{ 'badge-' . strtolower($order->status) }}">
                                                        {{ $statusList[$order->status] ?? $order->status }}
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

    @push('scripts')
        <script>
            const statusText = (code) => ({
                'pending': 'Chờ xử lý',
                'confirmed': 'Đã xác nhận',
                'processing': 'Đang chuẩn bị',
                'shipping': 'Đang giao hàng',
                'delivered': 'Đã giao (chờ khách xác nhận)',
                'completed': 'Đã hoàn tất',
                'cancelled': 'Đã huỷ',
                'cancelled_paid': 'Đã hủy (chờ hoàn tiền)',
                'refunded': 'Đã hoàn tiền',
                'delivery_failed': 'Giao thất bại'
            }[code] || code);

            const statusClass = (code) => ({
                'pending': 'badge bg-warning text-dark',
                'confirmed': 'badge bg-primary text-white',
                'processing': 'badge bg-info text-white',
                'shipping': 'badge bg-warning text-dark',
                'delivered': 'badge bg-secondary text-white',
                'completed': 'badge bg-success text-white',
                'cancelled': 'badge bg-danger text-white',
                'cancelled_paid': 'badge bg-warning text-dark',
                'refunded': 'badge bg-success text-white',
                'delivery_failed': 'badge bg-dark text-white'
            }[code] || 'badge bg-secondary text-white');

            const checkStatuses = () => {
                document.querySelectorAll('.order-status').forEach(cell => {
                    const id = cell.dataset.orderId;
                    const current = cell.dataset.status;
                    const url = "{{ route('admin.order.getStatuses', ':id') }}".replace(':id', id);

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            if (data.status && data.status !== current) {
                                cell.dataset.status = data.status;

                                const area = cell.querySelector('.status-area');
                                if (area) {
                                    area.innerHTML = `
                                                        <span class="status-badge ${statusClass(data.status)}">
                                                            ${statusText(data.status)}
                                                        </span>
                                                    `;
                                }
                                const dropdownBtn = cell.querySelector('.dropdown-toggle');
                                if (dropdownBtn) {
                                    dropdownBtn.className = `btn btn-sm dropdown-toggle ${statusClass(data.status)}`;
                                    dropdownBtn.textContent = statusText(data.status);
                                }
                            }
                        })
                        .catch(error => console.error(`Lỗi khi kiểm tra đơn hàng #${id}:`, error));
                });
            };

            setInterval(checkStatuses, 3000);
        </script>
    @endpush
@endsection
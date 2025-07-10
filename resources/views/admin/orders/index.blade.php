@extends('admin.layouts.default')

@section('title', 'Admin - Đơn hàng')

@section('content')
<main class="py-5">
    <style>
        body {
            font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', sans-serif;
            font-size: 13px;
        }

        .table th, .table td {
            font-size: 12px;
            vertical-align: middle;
            white-space: nowrap;
            padding: 0.45rem 0.5rem;
        }

        .table td.text-start {
            white-space: normal;
            word-break: break-word;
            max-width: 200px;
        }

        .order-img {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border-radius: .25rem;
            border: 1px solid #dee2e6;
        }

        .badge {
            font-size: 11px !important;
            padding: 0.35em 0.6em;
            border-radius: 0.35rem;
            font-weight: 500;
        }

        .btn-sm, .btn-xs, .action-btn {
            font-size: 11px;
            padding: 0.25rem 0.4rem;
            line-height: 1.2;
            white-space: nowrap;
        }

        .dropdown-toggle {
            padding: 0.25rem 0.5rem;
            font-size: 11px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .customer-name {
            max-width: 130px;
        }

        .product-type {
            max-width: 90px;
        }

        .text-small {
            font-size: 12px;
        }
        .pagination {
            margin-bottom: 0;
            flex-wrap: wrap;
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

                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Khách</th>
                                <th>Ảnh</th>
                                <th class="text-start">Sản phẩm</th>
                                <th>Loại</th>
                                <th>Đơn giá</th>
                                <th>Giảm</th>
                                <th>Ship</th>
                                <th>Tổng</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                @php
                                    $firstItem = $order->orderItems->first();
                                    $goc = $order->orderItems->sum(fn($i) => $i->price * $i->quantity);
                                    $statusList = [
                                        'pending' => 'Chờ xử lý',
                                        'processing' => 'Đang giao',
                                        'completed' => 'Đã giao',
                                        'cancelled' => 'Đã huỷ',
                                        'cancelled_paid' => 'Chờ hoàn tiền',
                                        'refunded' => 'Đã hoàn tiền',
                                    ];
                                    $statusClass = [
                                        'pending' => 'bg-warning text-dark',
                                        'processing' => 'bg-info text-white',
                                        'completed' => 'bg-success text-white',
                                        'cancelled' => 'bg-danger text-white',
                                        'cancelled_paid' => 'bg-warning text-dark',
                                        'refunded' => 'bg-success text-white',
                                    ][$order->status] ?? 'bg-secondary text-white';

                                    $availableTransitions = match($order->status) {
                                        'pending' => ['processing', 'cancelled'],
                                        'processing' => ['completed'],
                                        default => [],
                                    };

                                    $method = $order->payment_method;
                                    $methodLabel = $method === 'cod' ? 'COD' : ($method === 'vnpay' ? 'VNPay' : '---');
                                    $methodClass = $method === 'cod' ? 'bg-secondary' : ($method === 'vnpay' ? 'bg-primary' : 'bg-light');
                                @endphp
                                <tr>
                                    <td>#{{ $order->order_code }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $order->created_at->format('H:i') }}</span><br>
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="customer-name" title="{{ $order->shippingAddress->name ?? $order->user->name }}">
                                        {{ Str::limit($order->shippingAddress->name ?? $order->user->name, 18) }}
                                    </td>
                                    <td>
                                        @if ($firstItem?->productVariant?->product?->image)
                                            <img src="{{ asset('storage/' . $firstItem->productVariant->product->image) }}" alt class="order-img">
                                        @else
                                            <span class="text-muted">---</span>
                                        @endif
                                    </td>
                                    <td class="text-start" title="{{ $firstItem->productVariant->product->name ?? '---' }}">
                                        <strong>{{ Str::limit($firstItem->productVariant->product->name ?? '---', 30) }}</strong> x {{ $firstItem->quantity }}<br>
                                        <small class="text-muted">{{ number_format($firstItem->price, 0, ',', '.') }} đ</small>
                                        @if ($order->orderItems->count() > 1)
                                            <div>
                                                <a href="{{ route('admin.order.detail', $order->id) }}"
                                                    class="small fw-semibold text-primary text-decoration-none">
                                                    +{{ $order->orderItems->count() - 1 }} sản phẩm
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="product-type">
                                        {{ $firstItem->productVariant->color->name ?? '-' }} / {{ $firstItem->productVariant->size->name ?? '-' }}
                                    </td>
                                    <td>{{ number_format($goc, 0, ',', '.') }} đ</td>
                                    <td class="text-danger fw-semibold">{{ $order->discount > 0 ? '-' . number_format($order->discount, 0, ',', '.') . ' đ' : '0 đ' }}</td>
                                    <td class="text-success fw-semibold">{{ $goc >= 500000 ? 'Miễn phí' : number_format($order->shipping_fee, 0, ',', '.') . ' đ' }}</td>
                                    <td><strong>{{ number_format($order->total_price, 0, ',', '.') }} đ</strong></td>
                                    <td>
                                        @if (empty($availableTransitions))
                                            <span class="badge {{ $statusClass }}">{{ $statusList[$order->status] ?? '---' }}</span>
                                        @else
                                            <div class="dropdown">
                                                <button class="btn btn-sm dropdown-toggle badge {{ $statusClass }}" data-bs-toggle="dropdown">
                                                    {{ $statusList[$order->status] ?? '---' }}
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @foreach ($availableTransitions as $key)
                                                        <li>
                                                            <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST">
                                                                @csrf @method('PUT')
                                                                <input type="hidden" name="status" value="{{ $key }}">
                                                                <button class="dropdown-item" type="submit">{{ $statusList[$key] }}</button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                    <td><span class="badge {{ $methodClass }} text-white">{{ $methodLabel }}</span></td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                            <a href="{{ route('admin.order.detail', $order->id) }}" class="btn btn-sm btn-outline-dark action-btn">
                                                <i class="bi bi-eye"></i> Xem
                                            </a>
                                            @if ($order->status === 'cancelled_paid')
                                                <form action="{{ route('admin.order.refund', $order->id) }}" method="POST" onsubmit="return confirm('Xác nhận hoàn tiền?')" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-success action-btn">
                                                        <i class="bi bi-cash-coin"></i> Hoàn
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-3" style="overflow-x: auto;">
                        <div>
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

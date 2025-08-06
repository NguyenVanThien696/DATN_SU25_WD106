@extends('client.master')

@section('content')

    <main class="py-5">
        @if ($orders->count() > 0)
            <div class="container-fluid">
                <div class="card shadow-sm">
                    <div class="card-header text-dark fw-semibold" style="background-color: #e6f4ea;">
                        <h1 class="mb-0 h4 d-flex align-items-center"
                            style="font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', sans-serif; letter-spacing: 0.5px;">
                            <i class="bi bi-bag-check me-2 text-success fs-4"></i> Đơn hàng của bạn
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
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-hover align-middle text-center" style="min-width:1400px;">
                                <thead class="table-light">
                                    <tr>
                                        <th style="white-space: nowrap;">Mã đơn</th>
                                        <th style="white-space: nowrap;">Ngày đặt</th>
                                        <th>Ảnh</th>
                                        <th class="text-start">Sản phẩm</th>
                                        <th style="white-space: nowrap;">Chi tiết thanh toán</th>
                                        <th style="white-space: nowrap;">Trạng thái</th>
                                        <th style="white-space: nowrap;">Phương thức</th>
                                        <th style="white-space: nowrap;">TT Thanh toán</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        @php
                                            $firstItem = $order->orderItems->first();
                                            $goc = $order->orderItems->sum(fn($i) => $i->price * $i->quantity);
                                            $giam = $goc - $order->total_price + $order->shipping_fee;
                                        @endphp
                                        <tr data-order-id="{{ $order->id }}" data-order-status="{{ $order->status }}">
                                            <td>#{{ $order->order_code }}</td>
                                            <td>
                                                <span class="text-dark fw-bold">{{ $order->created_at->format('H:i') }}</span>
                                                {{ $order->created_at->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                @if (
                                                        $firstItem && $firstItem->productVariant &&
                                                        $firstItem->productVariant->product
                                                    )
                                                    <a
                                                        href="{{ route('client.products.detail', $firstItem->productVariant->product->id) }}">
                                                        <img src="{{ asset('storage/' . $firstItem->productVariant->product->image) }}"
                                                            alt="Ảnh SP" width="70" class="rounded border">
                                                    </a>
                                                @else
                                                    <span class="text-muted">Không có ảnh</span>
                                                @endif
                                            </td>

                                            <td class="text-start">
                                                @php
                                                    $variant = $firstItem?->productVariant;
                                                    $product = $variant?->product;
                                                    $quantity = $firstItem?->quantity ?? 1;
                                                @endphp

                                                @if ($firstItem && $product)
                                                    <div>
                                                        <strong>
                                                            <a href="{{ route('client.products.detail', $product->id) }}"
                                                                class="text-decoration-none text-dark">
                                                                {{ $product->name }}
                                                            </a>
                                                        </strong>
                                                        x {{ $quantity }}

                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $variant?->color?->name ?? '-' }} /
                                                            {{ $variant?->size?->name ?? '-' }}
                                                        </small>

                                                        <br>
                                                        <small class="text-muted">
                                                            {{ number_format($firstItem->price ?? 0, 0, ',', '.') }} đ
                                                        </small>
                                                    </div>

                                                    @if ($order->orderItems->count() > 1)
                                                        <a href="{{ route('client.order.detail', $order->id) }}" class="text-primary">
                                                            +{{ $order->orderItems->count() - 1 }} sản phẩm
                                                        </a>
                                                    @endif
                                                @elseif ($firstItem)
                                                    {{-- Có item nhưng thiếu variant/product --}}
                                                    <div>
                                                        <strong>Sản phẩm không còn tồn tại</strong>
                                                        x {{ $quantity }}
                                                        <br>
                                                        <small class="text-muted">- / -</small>
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ number_format($firstItem->price ?? 0, 0, ',', '.') }} đ
                                                        </small>
                                                    </div>

                                                    @if ($order->orderItems->count() > 1)
                                                        <a href="{{ route('client.order.detail', $order->id) }}" class="text-primary">
                                                            +{{ $order->orderItems->count() - 1 }} sản phẩm
                                                        </a>
                                                    @endif
                                                @else
                                                    {{-- Đơn không có item --}}
                                                    <em>Đơn hàng chưa có sản phẩm.</em>
                                                @endif
                                            </td>



                                            <td class="text-start">
                                                <div class="text-muted small">Tổng tiền:
                                                    <strong>{{ number_format($goc, 0, ',', '.') }} đ</strong>
                                                </div>

                                                @if ($order->discount > 0)
                                                    <div class="text-muted small">
                                                        Giảm giá: <strong class="text-success">
                                                            {{ $order->discount > 0 ? '-' . number_format($order->discount, 0, ',', '.') . ' đ' : '0 đ' }}
                                                        </strong>
                                                    </div>
                                                @endif

                                                <div class="text-muted small">
                                                    Phí ship:
                                                    <strong class="text-success">
                                                        {{ $goc >= 500000 ? 'Miễn phí' : number_format($order->shipping_fee, 0, ',', '.') . ' đ' }}
                                                    </strong>
                                                </div>

                                                <div class="fw-semibold text-dark mt-1">Thanh toán:
                                                    <span class="text-primary">{{ number_format($order->total_price, 0, ',', '.') }}
                                                        đ</span>
                                                </div>
                                            </td>

                                            <td>
                                                @php
                                                    $statusClass = [
                                                        'pending' => 'badge bg-warning',
                                                        'confirmed' => 'badge bg-primary',
                                                        'processing' => 'badge bg-info',
                                                        'shipping' => 'badge bg-warning text-dark',
                                                        'delivered' => 'badge bg-secondary',
                                                        'completed' => 'badge bg-success',
                                                        'cancelled' => 'badge bg-danger',
                                                        'cancelled_paid' => 'badge bg-warning text-dark',
                                                        'refunded' => 'badge bg-success',
                                                        'delivery_failed' => 'badge bg-dark',
                                                    ][$order->status] ?? 'badge bg-secondary';

                                                    $statusList = [
                                                        'pending' => 'Chờ xác nhận',
                                                        'confirmed' => 'Đã xác nhận',
                                                        'processing' => 'Đang chuẩn bị',
                                                        'shipping' => 'Đang giao hàng',
                                                        'delivered' => 'Đã giao (chờ xác nhận)',
                                                        'completed' => 'Đã hoàn tất',
                                                        'cancelled' => 'Đã huỷ',
                                                        'cancelled_paid' => 'Chờ hoàn tiền',
                                                        'refunded' => 'Đã hoàn tiền',
                                                        'delivery_failed' => 'Giao thất bại',
                                                    ];
                                                @endphp
                                                <span class="{{ $statusClass }}">
                                                    {{ $statusList[$order->status] ?? 'Không xác định' }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $paymentText = [
                                                        'cod' => 'COD',
                                                        'vnpay' => 'VNPay',
                                                    ][$order->payment_method] ?? 'Không xác định';

                                                    $paymentClass = [
                                                        'cod' => 'bg-secondary',
                                                        'vnpay' => 'bg-primary',
                                                    ][$order->payment_method] ?? 'bg-light';
                                                @endphp
                                                <span class="badge {{ $paymentClass }} text-white">{{ $paymentText }}</span>
                                            </td>
                                            <td>
                                                @if ($order->payment_status === 'paid')
                                                    <span class="badge bg-success">Đã thanh toán</span>
                                                @elseif ($order->payment_method === 'cod')
                                                    <span class="badge bg-secondary">Thanh toán khi nhận hàng</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center align-items-center gap-1">
                                                    @if ($order->status === 'pending')
                                                        <form action="{{ route('client.order.cancel', $order->id) }}" method="POST"
                                                            onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger px-2 py-1">
                                                                Hủy
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if ($order->status === 'delivered')
                                                        <form action="{{ route('client.order.confirmReceived', $order->id) }}"
                                                            method="POST" onsubmit="return confirm('Bạn đã nhận được hàng?')">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-success px-2 py-1">
                                                                Đã nhận
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <div class="d-flex gap-1">
                                                        <form action="{{ route('client.order.detail', $order->id) }}" method="GET">
                                                            <button type="submit" class="btn btn-sm btn-outline-dark px-2 py-1">
                                                                Xem
                                                            </button>
                                                        </form>

                                                        @if (
                                                                $order->status === 'completed' &&
                                                                $firstItem &&
                                                                $order->orderItems->count() === 1 &&
                                                                $firstItem->productVariant &&
                                                                !in_array($firstItem->id, $reviewedOrderItemIds ?? [])
                                                            )
                                                            <a href="{{ route('client.products.detail', $firstItem->productVariant->product_id) }}#review"
                                                                class="btn btn-sm btn-success px-2 py-1 d-inline-block">
                                                                Đánh giá
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="13" class="text-center text-muted py-4">
                                                Bạn chưa có đơn hàng nào.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container py-5" style="min-height: 70vh">
                <h4 class="text-center text-muted">Bạn chưa có đơn hàng nào.</h4>
            </div>
        @endif
    </main>
    @section('scripts')
        <script>
            function statusText(code) {
                const map = {
                    'pending': 'Chờ xác nhận',
                    'confirmed': 'Đã xác nhận',
                    'processing': 'Đang chuẩn bị',
                    'shipping': 'Đang giao hàng',
                    'delivered': 'Đã giao (chờ xác nhận)',
                    'completed': 'Đã hoàn tất',
                    'cancelled': 'Đã huỷ',
                    'delivery_failed': 'Giao thất bại'
                };
                return map[code] || code;
            }

            function statusClass(code) {
                const map = {
                    'pending': 'badge bg-warning',
                    'confirmed': 'badge bg-primary',
                    'processing': 'badge bg-info',
                    'shipping': 'badge bg-info',
                    'delivered': 'badge bg-secondary',
                    'completed': 'badge bg-success',
                    'cancelled': 'badge bg-danger',
                    'delivery_failed': 'badge bg-dark'
                };
                return map[code] || 'badge bg-secondary';
            }
            function updateActionButtons(tr, status, orderId, reviewedOrderIds) {
                const actionTd = tr.querySelector('td:last-child');
                let html = `<div class="d-flex justify-content-center align-items-center gap-1">`;

                if (status === 'pending') {
                    html += `
                                                                    <form action="/client/order/cancel/${orderId}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                        <button type="submit" class="btn btn-sm btn-danger px-2 py-1">Hủy</button>
                                                                    </form>
                                                                `;
                }

                if (status === 'delivered') {
                    html += `
                                                                    <form action="/client/order/confirm-received/${orderId}" method="POST" onsubmit="return confirm('Bạn đã nhận được hàng?')">
                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                        <input type="hidden" name="_method" value="PATCH">
                                                                        <button type="submit" class="btn btn-sm btn-success px-2 py-1">Đã nhận</button>
                                                                    </form>
                                                                `;
                }

                html += `
                                                                <form action="/client/order/detail/${orderId}" method="GET">
                                                                    <button type="submit" class="btn btn-sm btn-outline-dark px-2 py-1">Xem</button>
                                                                </form>
                                                            `;

                if (status === 'completed' && reviewedOrderIds && !reviewedOrderIds.includes(Number(orderId))) {
                    html += `
                                                                    <a href="/client/products/${orderId}#review" class="btn btn-sm btn-success px-2 py-1 d-inline-block">Đánh giá</a>
                                                                `;
                }

                html += `</div>`;
                actionTd.innerHTML = html;
            }

            setInterval(() => {
                document.querySelectorAll('tr[data-order-id]').forEach(tr => {
                    const orderId = tr.dataset.orderId;
                    const currentStatus = tr.dataset.orderStatus;

                    fetch(`/client/order/order-status/${orderId}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.status && data.status !== currentStatus) {
                                tr.dataset.orderStatus = data.status;
                                const statusCell = tr.querySelector('td:nth-child(6) span');
                                statusCell.className = statusClass(data.status);
                                statusCell.innerText = statusText(data.status);
                                updateActionButtons(tr, data.status, orderId, @json($reviewedOrderItemIds ?? []));
                            }
                        });
                });
            }, 3000); // mỗi 3s check lại
        </script>
    @endsection
@endsection
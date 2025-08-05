@extends('client.master')

@section('content')
<style>
.border:hover {
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
    transition: all 0.3s ease-in-out;
}
</style>

<main class="py-5">
    @if ($orders->count() > 0)
    <div class="container">
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

        <div class="mb-4" style="max-width: 900px; margin: 0 auto;">
            <h1 class="h4 fw-semibold text-dark d-flex align-items-center mb-4"
                style="font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', sans-serif; letter-spacing: 0.5px;">
                <i class="bi bi-bag-check me-2 text-success fs-4"></i> Đơn hàng của bạn
            </h1>

            @foreach ($orders as $order)
            @php
            $firstItem = $order->orderItems->first();
            $goc = $order->orderItems->sum(fn($i) => $i->price * $i->quantity);
            $giam = $goc - $order->total_price + $order->shipping_fee;

            // Xác định status dựa trên refundRequest nếu có
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

            'refund_pending' => 'badge bg-warning text-dark',
            'refund_rejected' => 'badge bg-danger',
            'refund_approved' => 'badge bg-success',
            ][$status] ?? 'badge bg-secondary';

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

            'refund_pending' => 'Chờ xét duyệt trả hàng / hoàn tiền',
            'refund_rejected' => 'Từ chối trả hàng / hoàn tiền',
            'refund_approved' => 'Đã hoàn tiền',
            ];

            // payment info như cũ
            $paymentText = [
            'cod' => 'COD',
            'vnpay' => 'VNPay',
            ][$order->payment_method] ?? 'Không xác định';

            $paymentClass = [
            'cod' => 'bg-secondary',
            'vnpay' => 'bg-primary',
            ][$order->payment_method] ?? 'bg-light';

            $paymentStatusText = $order->payment_status === 'paid'
            ? 'Đã thanh toán'
            : ($order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng' : 'Chưa thanh toán');

            $paymentStatusClass = $order->payment_status === 'paid'
            ? 'bg-success'
            : ($order->payment_method === 'cod' ? 'bg-secondary' : 'bg-warning text-dark');
            @endphp



            <div class="border rounded mb-4 shadow-sm p-3 bg-white" style="max-width: 900px; margin: 0 auto;">
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <span class="fw-semibold text-dark">Mã đơn:</span> #{{ $order->order_code }}
                        <span class="ms-3 text-muted small">{{ $order->created_at->format('H:i d/m/Y') }}</span>
                    </div>
                    <span class="{{ $statusClass }}">{{ $statusList[$status] ?? 'Không xác định' }}</span>

                </div>

                <div class="d-flex flex-wrap">
                    <div class="me-3">
                        @if ($firstItem && $firstItem->productVariant && $firstItem->productVariant->product)
                        <a href="{{ route('client.products.detail', $firstItem->productVariant->product->id) }}">
                            <img src="{{ asset('storage/' . $firstItem->productVariant->product->image) }}" alt="Ảnh SP"
                                width="80" class="rounded border">
                        </a>
                        @else
                        <span class="text-muted">Không có ảnh</span>
                        @endif
                    </div>

                    <div class="flex-grow-1">
                        <div>
                            <span class="fw-semibold">
                                {{ $firstItem->product_name }}
                            </span>
                            x {{ $firstItem->quantity }}
                        </div>

                        @if (!empty($firstItem->variant_name))
                        <div class="text-muted small">
                            {{ $firstItem->variant_name }}
                        </div>
                        @endif

                        <div class="text-muted small">
                            Đơn giá: {{ number_format($firstItem->price, 0, ',', '.') }} đ
                        </div>

                        @if ($order->orderItems->count() > 1)
                        <a href="{{ route('client.order.detail', $order->id) }}" class="text-primary small">
                            +{{ $order->orderItems->count() - 1 }} sản phẩm
                        </a>
                        @endif
                    </div>


                    <div class="text-end">
                        <div class="text-muted small">Tổng đơn gốc:</div>
                        <div class="fw-bold text-dark">
                            {{ number_format($goc, 0, ',', '.') }} đ
                        </div>

                        @if ($order->discount > 0)
                        <div class="text-muted small">
                            Giảm giá:
                            <span class="text-success">-{{ number_format($order->discount, 0, ',', '.') }} đ</span>
                        </div>
                        @endif

                        <div class="text-muted small">
                            Phí ship:
                            <span class="text-success">
                                {{ $goc >= 500000 ? 'Miễn phí' : number_format($order->shipping_fee, 0, ',', '.') . ' đ' }}
                            </span>
                        </div>

                        <div class="fw-semibold text-primary mt-1">
                            Thanh toán: {{ number_format($order->total_price, 0, ',', '.') }} đ
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                    <div>
                        <span class="badge {{ $paymentClass }} text-white me-1">{{ $paymentText }}</span>
                        <span class="badge {{ $paymentStatusClass }}">{{ $paymentStatusText }}</span>
                    </div>
                    <div class="d-flex gap-2 mt-2 mt-md-0">
                        @if ($order->status === 'pending')
                        <form action="{{ route('client.order.cancel', $order->id) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hủy</button>
                        </form>
                        @endif


                        @if (
                        $order->status === 'delivered' &&
                        empty($order->refundRequest)
                        )
                        <a href="{{ route('client.wallet.refund.create', $order->id) }}"
                            class="btn btn-sm btn-warning d-inline-block"
                            onclick="return confirm('Bạn chắc chắn muốn yêu cầu trả hàng cho đơn này?')">
                            Trả hàng / Hoàn tiền
                        </a>
                        @endif


                        @if ($order->status === 'delivered' && !$order->refundRequest)
                        <form action="{{ route('client.order.confirmReceived', $order->id) }}" method="POST"
                            onsubmit="return confirm('Bạn đã nhận được hàng?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success">Đã nhận được hàng</button>
                        </form>
                        @endif

                        <form action="{{ route('client.order.detail', $order->id) }}" method="GET">
                            <button type="submit" class="btn btn-sm btn-outline-dark">Xem</button>
                        </form>

                        @if (
                        $order->status === 'completed' &&
                        $firstItem &&
                        $order->orderItems->count() === 1 &&
                        $firstItem->productVariant &&
                        !in_array($firstItem->id, $reviewedOrderItemIds ?? [])
                        )
                        <a href="{{ route('client.products.detail', $firstItem->productVariant->product_id) }}#review"
                            class="btn btn-sm btn-success d-inline-block">Đánh giá</a>
                        @endif

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="container py-5" style="min-height: 70vh">
        <h4 class="text-center text-muted">Bạn chưa có đơn hàng nào.</h4>
    </div>
    @endif
</main>

@endsection
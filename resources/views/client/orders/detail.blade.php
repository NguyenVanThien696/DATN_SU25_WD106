@extends('client.master')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Chi tiết đơn hàng</h2>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="bi bi-geo-alt-fill me-2"></i>Địa Chỉ Nhận Hàng
        </div>
        <div class="card-body">
            <h5 class="mb-2 fw-semibold">{{ $order->shippingAddress->name ?? $order->customer_name }}</h5>
            <p class="mb-1">{{ $order->shippingAddress->phone ?? $order->customer_phone }}</p>
            <p class="mb-0">{{ $order->shippingAddress->address ?? $order->customer_address }}</p>


            <hr>
            <h6 class="fw-semibold text-muted">Trạng thái vận chuyển</h6>
            @php
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

            // Bảng thứ tự bước
            $statusSteps = [
            'pending' => 1,
            'confirmed' => 2,
            'shipping' => 3,
            'completed' => 4,
            'refund_pending' => 5,
            'refund_rejected' => 6,
            'refund_approved' => 7,
            'cancelled' => 99,
            ];

            $currentStep = $statusSteps[$status] ?? 0;
            @endphp

            <ul class="timeline">
                @if($status === 'cancelled')
                <li class="timeline-item completed">
                    <span class="time">{{ $order->updated_at->format('d/m/Y') }}</span>
                    <span class="desc fw-bold text-danger">Đã hủy</span>
                    <small class="text-muted">Đơn hàng đã bị hủy</small>
                </li>
                @endif
                @if($status === 'refund_approved')
                <li class="timeline-item completed">
                    <span class="time">{{ $order->updated_at->format('d/m/Y') }}</span>
                    <span class="desc fw-bold text-success">Đã hoàn tiền</span>
                    <small class="text-muted">Tiền đã được chuyển vào ví</small>
                </li>
                @endif
                @if($status === 'refund_rejected')
                <li class="timeline-item completed">
                    <span class="time">{{ $order->updated_at->format('d/m/Y') }}</span>
                    <span class="desc fw-bold text-danger">Từ chối hoàn tiền</span>
                    <small class="text-muted">Yêu cầu bị từ chối</small>
                </li>
                @endif
                @if($status === 'refund_pending')
                <li class="timeline-item completed">
                    <span class="time">{{ $order->updated_at->format('d/m/Y') }}</span>
                    <span class="desc fw-bold text-info">Chờ xét duyệt hoàn tiền</span>
                    <small class="text-muted">Yêu cầu đang được xử lý</small>
                </li>
                @endif
                @if(in_array($status, ['completed','refund_pending','refund_rejected','refund_approved']))
                <li class="timeline-item {{ $currentStep >= 4 ? 'completed' : '' }}">
                    <span class="time">{{ $order->updated_at->format('d/m/Y') }}</span>
                    <span class="desc fw-bold text-success">Đã hoàn thành</span>
                    <small class="text-muted">Giao hàng thành công</small>
                </li>
                @endif
                @if(in_array($status, ['shipping','completed','refund_pending','refund_rejected','refund_approved']))
                <li class="timeline-item {{ $currentStep >= 3 ? 'completed' : '' }}">
                    <span class="time">{{ $order->updated_at->format('d/m/Y') }}</span>
                    <span class="desc fw-bold text-warning">Đang giao</span>
                    <small class="text-muted">Đơn hàng đang được vận chuyển</small>
                </li>
                @endif
                @if($status !== 'cancelled')
                <li class="timeline-item {{ $currentStep >= 2 ? 'completed' : '' }}">
                    <span class="time">{{ $order->updated_at->format('d/m/Y') }}</span>
                    <span class="desc fw-bold text-primary">Đã xác nhận</span>
                    <small class="text-muted">Đơn hàng đã được xác nhận</small>
                </li>
                @endif

                <li class="timeline-item {{ $currentStep >= 1 ? 'completed' : '' }}">
                    <span class="time">{{ $order->created_at->format('d/m/Y') }}</span>
                    <span class="desc fw-bold">Đã đặt hàng</span>
                    <small class="text-muted">Chờ xác nhận</small>
                </li>
            </ul>

        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white fw-semibold">
            <i class="bi bi-box-seam me-2"></i> Sản phẩm trong đơn hàng
        </div>
        <div class="card-body">
            @foreach ($order->orderItems as $item)
            <div class="d-flex border-bottom py-3">
                @if ($item->productVariant && $item->productVariant->product)
                <a href="{{ route('client.products.detail', $item->productVariant->product->id) }}">
                    <img src="{{ asset('storage/' . $item->productVariant->product->image) }}" alt="Ảnh SP" width="80"
                        class="rounded border me-3">
                </a>
                @else
                <div style="width: 80px; height: 80px;"
                    class="rounded border me-3 bg-light d-flex align-items-center justify-content-center text-muted">
                    Không có ảnh
                </div>
                @endif

                <div class="flex-grow-1">
                    <div class="fw-semibold">
                        {{ $item->product_name ?? ($item->productVariant->product->name ?? 'Sản phẩm đã bị xóa') }}
                    </div>

                    <div class="text-muted">
                        Phân loại:
                        {{ $item->variant_name ?? (($item->productVariant->color->name ?? '-') . ' / ' . ($item->productVariant->size->name ?? '-')) }}
                    </div>

                    <div>Số lượng: x{{ $item->quantity }}</div>
                </div>

                <div class="text-end fw-bold text-danger">
                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ
                </div>
                <div style="width: 140px;" class="text-end">
                    @if ($order->status === 'completed' && !in_array($item->id, $reviewedOrderItemIds ?? []))
                    <a href="{{ route('client.products.detail', $item->productVariant->product->id) }}#review"
                        class="btn btn-sm btn-success">
                        Đánh giá
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>


    </div>

    @php
    $paymentClass = match($order->payment_method) {
    'cod' => 'bg-warning',
    'vnpay' => 'bg-primary',
    default => 'bg-secondary',
    };
    $paymentText = match($order->payment_method) {
    'cod' => 'Thanh toán khi nhận hàng',
    'vnpay' => 'Thanh toán VNPay',
    default => 'Không xác định',
    };
    @endphp

    <div class="card shadow">
        <div class="card-header bg-success text-white fw-semibold">
            <i class="bi bi-cash-stack me-2"></i> Thanh toán
        </div>
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tr>
                    <td class="text-end">Tạm tính:</td>
                    <td class="text-end">
                        {{ number_format($order->orderItems->sum(fn($item) => $item->price * $item->quantity), 0, ',', '.') }}đ
                    </td>
                </tr>
                <tr>
                    <td class="text-end">Phí vận chuyển:</td>
                    <td class="text-end">
                        @if ($order->shipping_fee == 0)
                        Miễn phí
                        @else
                        {{ number_format($order->shipping_fee, 0, ',', '.') }}đ
                        @endif
                    </td>
                </tr>

                @if ($order->discount > 0)
                <tr>
                    <td class="text-end text-danger">Giảm giá:</td>
                    <td class="text-end text-danger">- {{ number_format($order->discount, 0, ',', '.') }}đ</td>
                </tr>
                @endif

                <tr class="fw-bold fs-5">
                    <td class="text-end">Tổng thanh toán:</td>
                    <td class="text-end text-danger">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                </tr>
                <tr>
                    <td class="text-end">Trạng thái thanh toán:</td>
                    <td class="text-end">
                        <span class="badge {{ $paymentClass }}">{{ $paymentText }}</span>
                    </td>
                </tr>

            </table>
        </div>
    </div>

    <div class="text-end mt-4">
        <a href="{{ route('client.order.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>
</div>

{{-- CSS timeline --}}
<style>
.timeline {
    list-style: none;
    padding-left: 0;
    position: relative;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    padding-left: 30px;
    margin-bottom: 1rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: 3px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #adb5bd;
}

.timeline-item.completed::before {
    background: #198754;
}

.time {
    font-size: 0.9rem;
    color: #6c757d;
}

.desc {
    display: block;
}
</style>
@endsection
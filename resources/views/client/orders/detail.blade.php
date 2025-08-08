@extends('client.master')

@section('content')
    <div class="container my-5">
        <h2 class="text-center mb-4">Chi tiết đơn hàng</h2>

        {{-- Địa chỉ nhận hàng + trạng thái giao hàng --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white fw-semibold">
                <i class="bi bi-geo-alt-fill me-2"></i>Địa Chỉ Nhận Hàng
            </div>
            <div class="card-body">
                <h5 class="mb-2 fw-semibold">{{ $order->shippingAddress->name ?? $order->user->name }}</h5>
                <p class="mb-1">{{ $order->shippingAddress->phone ?? $order->user->phone }}</p>
                <p class="mb-0">{{ $order->shippingAddress->address ?? $order->user->address }}</p>

                <hr>
                <h6 class="fw-semibold text-muted">Trạng thái vận chuyển</h6>
                <ul class="timeline">
                    @if ($order->status === 'completed')
                        <li class="timeline-item completed">
                            <span class="time">{{ $order->updated_at->format('H:i d/m/Y') }}</span>
                            <span class="desc fw-bold text-success">Đã hoàn thành</span>
                            <small class="text-muted">Giao hàng thành công</small>
                        </li>
                    @elseif ($order->status === 'cancelled')
                        <li class="timeline-item completed">
                            <span class="time">{{ $order->updated_at->format('H:i d/m/Y') }}</span>
                            <span class="desc fw-bold text-danger">Đã hủy</span>
                            <small class="text-muted">Đơn hàng đã bị hủy</small>
                        </li>
                    @endif

                    @if (in_array($order->status, ['shipping', 'completed']))
                        <li class="timeline-item completed">
                            <span class="time">{{ $order->updated_at->format('H:i d/m/Y') }}</span>
                            <span class="desc fw-bold text-warning">Đang giao</span>
                            <small class="text-muted">Đơn hàng đang được vận chuyển</small>
                        </li>
                    @endif

                    @if (in_array($order->status, ['confirmed', 'shipping', 'completed']))
                        <li class="timeline-item completed">
                            <span class="time">{{ $order->updated_at->format('H:i d/m/Y') }}</span>
                            <span class="desc fw-bold text-primary">Đã xác nhận</span>
                            <small class="text-muted">Đơn hàng đã được xác nhận</small>
                        </li>
                    @endif

                    <li class="timeline-item completed">
                        <span class="time">{{ $order->created_at->format('H:i d/m/Y') }}</span>
                        <span class="desc fw-bold">Đã đặt hàng</span>
                        <small class="text-muted">Chờ xác nhận</small>
                    </li>
                </ul>


            </div>
        </div>

        {{-- Sản phẩm --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white fw-semibold">
                <i class="bi bi-box-seam me-2"></i> Sản phẩm trong đơn hàng
            </div>
            <div class="card-body">
                @foreach ($order->orderItems as $item)
                    <div class="d-flex border-bottom py-3 align-items-center flex-wrap">

                        {{-- Ảnh sản phẩm --}}
                        <a href="{{ route('client.products.detail', $item->productVariant->product->id) }}" class="me-3">
                            <img src="{{ asset('storage/' . $item->productVariant->product->image) }}" alt="Ảnh SP" width="80"
                                class="rounded border">
                        </a>

                        {{-- Thông tin sản phẩm --}}
                        <div class="flex-grow-1 me-3" style="min-width: 200px;">
                            <div class="fw-semibold">
                                <a href="{{ route('client.products.detail', $item->productVariant->product->id) }}"
                                    class="text-decoration-none text-dark">
                                    {{ $item->productVariant->product->name }}
                                </a>
                            </div>
                            <div class="text-muted">
                                Phân loại: {{ $item->productVariant->color->name ?? '-' }} /
                                {{ $item->productVariant->size->name ?? '-' }}
                            </div>
                            <div>Số lượng: x{{ $item->quantity }}</div>
                        </div>

                        {{-- Thành tiền --}}
                        <div class="text-danger fw-bold text-end me-3" style="width: 140px; white-space: nowrap;">
                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ
                        </div>

                        {{-- Nút đánh giá (nếu có) --}}
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

        {{-- Thanh toán --}}
        @php
            $paymentClass = match ($order->payment_method) {
                'cod' => 'bg-warning',
                'vnpay' => 'bg-primary',
                default => 'bg-secondary',
            };
            $paymentText = match ($order->payment_method) {
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
                        <td class="text-end">Phương thức thanh toán:</td>
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
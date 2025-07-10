@extends('client.master')

@section('content')
<main class="py-5">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header text-dark fw-semibold" style="background-color: #e6f4ea;">
                <h1 class="mb-0 h4 d-flex align-items-center" style="font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', sans-serif; letter-spacing: 0.5px;">
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
                                <th style="white-space: nowrap;">Khách hàng</th>
                                <th>Ảnh</th>
                                <th class="text-start">Sản phẩm</th>
                                <th style="white-space: nowrap;">Phân loại</th>
                                <th style="white-space: nowrap;">Đơn giá</th>
                                <th style="white-space: nowrap;">Giảm giá</th>
                                <th style="white-space: nowrap;">Phí ship</th>
                                <th style="white-space: nowrap;">Thanh toán</th>
                                <th style="white-space: nowrap;">Trạng thái</th>
                                <th style="white-space: nowrap;">Thanh toán</th>
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
                            <tr>
                                <td>#{{ $order->order_code }}</td>
                                <td>
                                    <span class="text-dark fw-bold">{{ $order->created_at->format('H:i') }}</span>
                                    {{ $order->created_at->format('d/m/Y') }}
                                </td>
                                <td>{{ $order->user->name }}</td>
                                <td>
                                    @if ($firstItem && $firstItem->productVariant && $firstItem->productVariant->product)
                                        <img src="{{ asset('storage/' . $firstItem->productVariant->product->image) }}"
                                            alt="Ảnh SP" width="70" class="rounded border">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td class="text-start">
                                    <div>
                                        <strong>{{ $firstItem->productVariant->product->name }}</strong> x {{ $firstItem->quantity }}<br>
                                        <small class="text-muted">{{ number_format($firstItem->price, 0, ',', '.') }} đ</small>
                                    </div>
                                    @if ($order->orderItems->count() > 1)
                                    <a href="{{ route('client.order.detail', $order->id) }}" class="text-primary">
                                        +{{ $order->orderItems->count() - 1 }} sản phẩm
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $firstItem->productVariant->color->name ?? '-' }} /
                                    {{ $firstItem->productVariant->size->name ?? '-' }}
                                </td>
                                <td>{{ number_format($goc, 0, ',', '.') }} đ</td>
                                <td class="text-success fw-semibold">
                                    {{ $order->discount > 0 ? '-' . number_format($order->discount, 0, ',', '.') . ' đ' : '0 đ' }}
                                </td>
                                <td class="text-success fw-semibold">
                                    @if ($goc >= 500000)
                                        Miễn phí
                                    @else
                                        {{ number_format($order->shipping_fee, 0, ',', '.') }} đ
                                    @endif
                                </td>
                                <td><strong>{{ number_format($order->total_price, 0, ',', '.') }} đ</strong></td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'pending' => 'badge bg-warning',
                                            'processing' => 'badge bg-info',
                                            'completed' => 'badge bg-success',
                                            'cancelled' => 'badge bg-danger',
                                            'cancelled_paid' => 'badge bg-warning text-dark',
                                            'refunded' => 'badge bg-success',
                                        ][$order->status] ?? 'badge bg-secondary';

                                        $statusList = [
                                            'pending' => 'Đang chờ xử lí',
                                            'processing' => 'Đang giao hàng',
                                            'completed' => 'Đã hoàn thành',
                                            'cancelled' => 'Đã hủy',
                                            'cancelled_paid' => 'Đã hủy (chờ hoàn tiền)',
                                            'refunded' => 'Đã hoàn tiền',
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
                               <td class="align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        @if ($order->status === 'pending')
                                        <form action="{{ route('client.order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger px-2 py-1">
                                                Hủy
                                            </button>
                                        </form>
                                        @endif

                                        <form action="{{ route('client.order.detail', $order->id) }}" method="GET">
                                            <button type="submit" class="btn btn-sm btn-outline-dark px-2 py-1">
                                                Xem
                                            </button>
                                        </form>
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
</main>
@endsection
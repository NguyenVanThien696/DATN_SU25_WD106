@extends('client.master')

@section('content')
<main class="py-5">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Đơn hàng của bạn</h5>
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
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Phân loại</th>
                                <th>Thành tiền</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>
                                    @php
                                    $firstItem = $order->orderItems->first();
                                    @endphp
                                    <img src="{{ asset('storage/' . $firstItem->productVariant->product->image) }}"
                                        alt="Ảnh SP" width="70" class="rounded border">
                                </td>

                                <td class="text-start">
                                    @foreach ($order->orderItems as $item)
                                    <div>
                                        <strong>{{ $item->productVariant->product->name }}</strong> x
                                        {{ $item->quantity }}
                                        <br>
                                        <small class="text-muted">
                                            {{ number_format($item->price, 0, ',', '.') }} đ
                                        </small>
                                    </div>
                                    @endforeach
                                </td>

                                <td>
                                    @foreach ($order->orderItems as $item)
                                    <div>{{ $item->productVariant->color->name }} /
                                        {{ $item->productVariant->size->name }}</div>
                                    @endforeach
                                </td>

                                <td>
                                    <strong>{{ number_format($order->total_price, 0, ',', '.') }} đ</strong>
                                    @if($order->orderItems->sum(fn($i) => $i->price * $i->quantity) > $order->total_price)
                                        <br>
                                        <small class="text-success">
                                            (Đã áp dụng mã giảm giá)
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @php
                                    $statusClass = [
                                    'pending' => 'badge bg-warning',
                                    'processing' => 'badge bg-info',
                                    'completed' => 'badge bg-success',
                                    'cancelled' => 'badge bg-danger',
                                    'cancelled_paid' => 'badge bg-warning text-dark',
                                    'refunded' => 'badge  bg-success',
                                    ][$order->status] ?? 'badge bg-secondary';

                                    $statusList = [
                                    'pending' => 'Đang chờ xử lí',
                                    'processing' => 'Đang giao hàng',
                                    'completed' => 'Đã hoàn thành',
                                    'cancelled' => 'Đã hủy',
                                    'cancelled_paid' => 'Đã hủy (đang đợi hoàn tiền)',
                                    'refunded' => 'Đã hoàn tiền',
                                    ];
                                    @endphp
                                    <span
                                        class="{{ $statusClass }}">{{ $statusList[$order->status] ?? 'Không xác định' }}</span>
                                </td>

                                <td>
                                    @php
                                    $paymentText = [
                                    'cod' => 'Thanh toán khi nhận hàng',
                                    'vnpay' => 'Thanh toán VNPay',
                                    ][$order->payment_method] ?? 'Không xác định';

                                    $paymentClass = [
                                    'cod' => 'bg-secondary',
                                    'vnpay' => 'bg-primary',
                                    ][$order->payment_method] ?? 'bg-light';
                                    @endphp
                                    <span class="badge {{ $paymentClass }} text-white">{{ $paymentText }}</span>
                                </td>

                                <td>
                                    @if ($order->status === 'pending')
                                    <form action="{{ route('client.order.cancel', $order->id) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-x-circle"></i> Hủy
                                        </button>
                                    </form>
                                    @endif

                                    <a href="{{ route('client.order.detail', $order->id) }}"
                                        class="btn btn-sm btn-outline-dark">
                                        <i class="bi bi-eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @if ($orders->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Bạn chưa có đơn hàng nào.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
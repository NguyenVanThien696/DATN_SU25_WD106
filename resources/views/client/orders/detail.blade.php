@extends('client.master')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">Chi tiết đơn hàng</h2>

    <div class="card mb-4 shadow">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="bi bi-person-circle me-2"></i>Thông tin khách hàng
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <tbody>
                    <tr>
                        <th class="w-25">Họ tên người nhận:</th>
                        <td>{{ $order->shippingAddress->name ?? $order->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $order->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Số điện thoại:</th>
                        <td>{{ $order->shippingAddress->phone ?? $order->user->phone }}</td>
                    </tr>
                    <tr>
                        <th>Địa chỉ nhận hàng:</th>
                        <td>{{ $order->shippingAddress->address ?? $order->user->address }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="card mb-4 shadow">
        <div class="card-header bg-success text-white fw-semibold">
            <i class="bi bi-receipt me-2"></i>Thông tin đơn hàng
        </div>
        <div class="card-body p-0">
            @php
            $statusClass = match($order->status) {
            'pending' => 'bg-warning',
            'processing' => 'bg-info',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary',
            };

            $statusText = match($order->status) {
            'pending' => 'Đang chờ xử lí',
            'processing' => 'Đang giao hàng',
            'completed' => 'Đã hoàn thành',
            'cancelled' => 'Đã hủy',
            default => 'Không xác định',
            };

            $paymentClass = match($order->payment_method) {
            'cod' => 'bg-warning',
            'momo' => 'bg-danger',
            default => 'bg-secondary',
            };

            $paymentText = match($order->payment_method) {
            'cod' => 'Thanh toán khi nhận hàng',
            'momo' => 'Thanh toán Momo',
            default => 'Không xác định',
            };

            $paymentStatusClass = $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning';
            $paymentStatusText = $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán';
            @endphp

            <table class="table table-bordered table-striped mb-0">
                <tbody>
                    <tr>
                        <th class="w-25">Ngày đặt hàng:</th>
                        <td>{{ $order->created_at->format('H:i d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Trạng thái đơn hàng:</th>
                        <td><span class="badge {{ $statusClass }}">{{ $statusText }}</span></td>
                    </tr>
                    <tr>
                        <th>Phương thức thanh toán:</th>
                        <td><span class="badge {{ $paymentClass }}">{{ $paymentText }}</span></td>
                    </tr>
                    <tr>
                        <th>Trạng thái thanh toán:</th>
                        <td><span class="badge {{ $paymentStatusClass }}">{{ $paymentStatusText }}</span></td>
                    </tr>
                    <tr>
                        <th class="w-25">Ghi chú</th>
                        <td>{{ $order->shippingAddress->note ?? $order->user->note }}</td>
                    </tr>
                    <tr>
                        <th>Tổng tiền:</th>
                        <td class="text-danger fw-bold fs-5">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="card shadow">
        <div class="card-header bg-info text-white fw-semibold">
            <i class="bi bi-box-seam me-2"></i>Sản phẩm trong đơn hàng
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Phân loại</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($order->orderItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $item->productVariant->product->image) }}" alt="Ảnh SP"
                                    width="70" class="rounded border">
                            </td>
                            <td>{{ $item->productVariant->product->name }}</td>
                            <td>{{ $item->productVariant->color->name ?? '-' }} /
                                {{ $item->productVariant->size->name ?? '-' }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-danger fw-semibold">
                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light fw-bold text-center">
                        <tr>
                            <td colspan="6">Tổng cộng</td>
                            <td class="text-danger">
                                {{ number_format($order->total_price, 0, ',', '.') }}đ
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="text-end mt-4">
        <a href="{{ route('client.order.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>
</div>
@endsection
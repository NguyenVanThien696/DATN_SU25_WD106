@extends('admin.layouts.default')

@section('title', 'Admin - Đơn hàng')

@section('content')
<main class="h-full">
    <div class="page-container relative h-full flex flex-auto flex-col px-4 sm:px-6 md:px-8 py-4 sm:py-6">
        <div class="container mx-auto">
            <div class="card adaptable-card">
                <div class="card-body">
                    <div class="lg:flex items-center justify-between mb-4">
                        <h3 class="mb-4 lg:mb-0">Danh sách đơn hàng</h3>
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="overflow-x-auto mt-5">
                        <table id="product-list-data-table" class="table-default table-hover data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ Tên</th>
                                    <th>Địa chỉ</th>
                                    <th>Tổng tiền</th>
                                    <th>Phương Thức Thanh Toán</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Chi Tiết</th>
                                </tr>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->shippingAddress->name ?? $order->user->name }}</td>
                                    <td>{{ $order->shippingAddress->address ?? $order->user->address }}</td>
                                    <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>

                                    <td>
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
                                        <span class="badge {{ $paymentClass }}">
                                            {{ $paymentText }}
                                        </span>
                                    </td>

                                    <td>
                                        @php
                                        $statusClass = match($order->status) {
                                        'pending' => 'bg-warning',
                                        'processing' => 'bg-info',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        'cancelled_paid' => 'bg-warning text-dark',
                                        'refunded' => 'bg-success',
                                        default => 'bg-secondary',
                                        };

                                        $statusList = [
                                        'pending' => 'Đang chờ xử lí',
                                        'processing' => 'Đang giao hàng',
                                        'completed' => 'Đã hoàn thành',
                                        'cancelled' => 'Đã hủy',
                                        'cancelled_paid' => 'Đã hủy (đang đợi hoàn tiền)',
                                        'refunded' => 'Đã hoàn tiền',
                                        ];

                                        $availableTransitions = match($order->status) {
                                        'pending' => ['processing', 'completed', 'cancelled'],
                                        'processing' => ['completed'],
                                        default => [],
                                        };
                                        @endphp

                                        @if (empty($availableTransitions))
                                        <span class="badge {{ $statusClass }}">
                                            {{ $statusList[$order->status] ?? 'Không xác định' }}
                                        </span>
                                        @else
                                        <div class="dropdown">
                                            <button class="btn btn-sm dropdown-toggle {{ $statusClass }}" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $statusList[$order->status] ?? 'Không xác định' }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach ($availableTransitions as $key)
                                                <li>
                                                    <form action="{{ route('admin.order.updateStatus', $order->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="{{ $key }}">
                                                        <button class="dropdown-item" type="submit">
                                                            {{ $statusList[$key] ?? ucfirst($key) }}
                                                        </button>
                                                    </form>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                    </td>


                                    <td>
                                        <a href="{{ route('admin.order.detail', $order->id) }}"
                                            class="btn btn-sm btn-outline-dark">
                                            <i class="bi bi-eye"></i> Xem
                                        </a>
                                        @if ($order->status === 'cancelled_paid')
                                            <form action="{{ route('admin.order.refund', $order->id) }}" method="POST"
                                                onsubmit="return confirm('Xác nhận hoàn tiền cho đơn hàng này?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-cash-coin"></i> Hoàn tiền
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="mt-5">
                            {{ $orders ->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
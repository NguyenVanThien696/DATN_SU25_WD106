@extends('client.master')

@section('content')
<link rel="stylesheet" href="{{ asset('build/css/style.css') }}">
<main class="h-full">
    <div class="page-container relative h-full flex flex-auto flex-col px-4 sm:px-6 md:px-8 py-4 sm:py-6">
        <div class="container mx-auto">
            <div class="card adaptable-card">
                <div class="card-body">
                    <div class="lg:flex items-center justify-between mb-4">
                        <h3 class="mb-4 lg:mb-0">Đơn hàng của bạn</h3>
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
                                    <th>Ảnh sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Phân loại</th>
                                    <th>Thành tiền</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Chi tiết</th>
                                </tr>
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

                                    <td>
                                        @foreach ($order->orderItems as $item)
                                        <div>
                                            {{ $item->productVariant->product->name }} <strong>x</strong>
                                            {{ $item->quantity }}<br>
                                            <small>
                                                Đơn giá: {{ number_format($item->price, 0, ',', '.') }} đ 
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
                                        @php
                                        $total = $order->orderItems->sum(fn($i) => $i->price * $i->quantity);
                                        @endphp
                                        <strong>{{ number_format($total, 0, ',', '.') }} đ</strong>
                                    </td>

                                    <td>
                                        @php
                                        $statusClass = match($order->status) {
                                        'pending' => 'bg-warning',
                                        'processing' => 'bg-info',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary',
                                        };

                                        $statusList = [
                                        'pending' => 'Đang chờ xử lí',
                                        'processing' => 'Đang giao hàng',
                                        'completed' => 'Đã hoàn thành',
                                        'cancelled' => 'Đã hủy',
                                        ];
                                        @endphp

                                        <span class="badge {{ $statusClass }}">
                                            {{ $statusList[$order->status] ?? 'Không xác định' }}
                                        </span>
                                    </td>

                                    <td>
                                        <a href="{{ route('client.order.detail', $order->id) }}"
                                            class="btn btn-sm btn-outline-dark">
                                            <i class="bi bi-eye"></i> Xem
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
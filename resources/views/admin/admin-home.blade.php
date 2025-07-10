@extends('admin.layouts.default')

@section('title', 'Bảng điều khiển')

@push('styles')
    <style>
        .stat-card {
            border-radius: 1rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .stat-card:hover {
            transform: scale(1.02);
        }

        .stat-icon {
            font-size: 1.75rem;
        }

        .badge-status {
            font-size: 0.8rem;
            padding: 0.5em 0.75em;
            border-radius: 0.5rem;
            color: #fff;
            display: inline-block;
            margin: 0.25rem;
        }
    </style>
@endpush

@section('content')
    <main class="py-4">
        <div class="container-fluid">
            <h2 class="mb-4 fw-semibold">Thống kê tổng quan</h2>

            <!-- Cards Thống kê -->
            <div class="row row-cols-1 row-cols-md-5 g-4">
                @php
                    $cards = [
                        [
                            'label' => 'Tổng đơn hàng',
                            'value' => $totalOrders,
                            'icon' => 'fas fa-shopping-cart',
                            'color' => 'primary',
                        ],
                        [
                            'label' => 'Đơn hôm nay',
                            'value' => $ordersToday,
                            'icon' => 'fas fa-calendar-day',
                            'color' => 'info',
                        ],
                        [
                            'label' => 'Tỉ lệ hoàn thành',
                            'value' => $completionRate . '%',
                            'icon' => 'fas fa-check-circle',
                            'color' => 'success',
                        ],
                        [
                            'label' => 'Doanh thu hôm nay',
                            'value' => number_format($revenueToday, 0, ',', '.') . '₫',
                            'icon' => 'fas fa-coins',
                            'color' => 'success',
                        ],
                        [
                            'label' => 'Doanh thu tháng',
                            'value' => number_format($revenueMonth, 0, ',', '.') . '₫',
                            'icon' => 'fas fa-chart-line',
                            'color' => 'success',
                        ],
                        [
                            'label' => 'Tổng sản phẩm',
                            'value' => $totalProducts,
                            'icon' => 'fas fa-box',
                            'color' => 'dark',
                        ],
                        [
                            'label' => 'Sản phẩm đã bán',
                            'value' => $totalSold,
                            'icon' => 'fas fa-boxes',
                            'color' => 'secondary',
                        ],
                        [
                            'label' => 'Sản phẩm sắp hết',
                            'value' => $lowStockCount,
                            'icon' => 'fas fa-exclamation-triangle',
                            'color' => 'danger',
                        ],
                        [
                            'label' => 'Khách hàng',
                            'value' => $totalCustomers,
                            'icon' => 'fas fa-users',
                            'color' => 'info',
                        ],
                        [
                            'label' => 'Mã giảm giá',
                            'value' => $totalCoupons,
                            'icon' => 'fas fa-ticket-alt',
                            'color' => 'secondary',
                        ],
                    ];
                @endphp
                @foreach ($cards as $index => $card)
                    @php
                        // Định nghĩa route tương ứng nếu cần
                        $cardRoutes = [
                            0 => route('admin.order.index'), // Tổng đơn hàng
                            1 => route('admin.order.index', ['date' => now()->toDateString()]), // Đơn hôm nay
                            7 => route('admin.product.filter', ['low_stock' => 1]), // Sản phẩm sắp hết
                        ];
                        $url = $cardRoutes[$index] ?? null;
                    @endphp

                    <div class="col">
                        @if ($url)
                            <a href="{{ $url }}" class="text-decoration-none text-dark">
                        @endif

                            <div class="card stat-card p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-muted small">{{ $card['label'] }}</div>
                                        <div class="h5 fw-bold">{{ $card['value'] }}</div>
                                    </div>
                                    <div class="text-{{ $card['color'] }} stat-icon">
                                        <i class="{{ $card['icon'] }}"></i>
                                    </div>
                                </div>
                            </div>

                            @if ($url)
                                </a>
                            @endif
                    </div>
                @endforeach

            </div>

            <!-- Biểu đồ doanh thu và trạng thái -->
            <div class="row mt-5">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header fw-bold">Biểu đồ doanh thu 7 ngày</div>
                        <div class="card-body">
                            <canvas id="revenueChart" height="150"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header fw-bold">Tình trạng đơn hàng</div>
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-md-2 g-2">
                                @php
                                    $statusColors = [
                                        'Chờ xử lý' => '#ffc107',
                                        'Đang giao' => '#17a2b8',
                                        'Đã giao' => '#28a745',
                                        'Đã huỷ' => '#dc3545',
                                        'Chờ hoàn tiền' => '#6c757d',
                                        'Đã hoàn tiền' => '#0d6efd',
                                    ];
                                    $statusRoutes = [
                                        'Chờ xử lý' => 'pending',
                                        'Đang giao' => 'processing',
                                        'Đã giao' => 'completed',
                                        'Đã huỷ' => 'cancelled',
                                        'Chờ hoàn tiền' => 'cancelled_paid',
                                        'Đã hoàn tiền' => 'refunded',
                                    ];
                                @endphp

                                @foreach ($statusColors as $label => $color)
                                    <div class="col">
                                        <a href="{{ route('admin.order.filter', ['status' => $statusRoutes[$label]]) }}"
                                            class="text-decoration-none">
                                            <div class="d-flex justify-content-between align-items-center p-2 border rounded"
                                                style="background-color: {{ $color }}10;">
                                                <span style="color: {{ $color }};">{{ $label }}</span>
                                                <span class="badge"
                                                    style="background-color: {{ $color }};">{{ $orderStatusChart[$statusRoutes[$label]] ?? 0 }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Đơn hàng mới & Top sản phẩm -->
            <div class="row mt-5">
                <!-- Đơn hàng mới nhất -->
                <div class="col-md-6">
                    <div class="card shadow-sm rounded-4 h-100">
                        <div class="card-header fw-bold d-flex justify-content-between align-items-center bg-light">
                            <span><i class="fas fa-clock me-2 text-primary"></i>Đơn hàng mới nhất</span>
                            <a href="{{ route('admin.order.index') }}" class="btn btn-sm btn-outline-primary">Xem tất
                                cả</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped align-middle mb-0 text-nowrap">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="min-width: 130px;">Mã đơn hàng</th>
                                            <th>Khách hàng</th>
                                            <th style="min-width: 130px;">Tổng tiền</th>
                                            <th style="min-width: 130px;">Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $statusMap = [
                                                'pending' => [
                                                    'label' => 'Chờ xử lý',
                                                    'class' => 'warning',
                                                    'icon' => 'fas fa-clock',
                                                ],
                                                'processing' => [
                                                    'label' => 'Đang giao',
                                                    'class' => 'info',
                                                    'icon' => 'fas fa-shipping-fast',
                                                ],
                                                'completed' => [
                                                    'label' => 'Đã giao',
                                                    'class' => 'success',
                                                    'icon' => 'fas fa-check-circle',
                                                ],
                                                'cancelled' => [
                                                    'label' => 'Đã huỷ',
                                                    'class' => 'danger',
                                                    'icon' => 'fas fa-times-circle',
                                                ],
                                                'cancelled_paid' => [
                                                    'label' => 'Chờ hoàn tiền',
                                                    'class' => 'secondary',
                                                    'icon' => 'fas fa-undo',
                                                ],
                                                'refunded' => [
                                                    'label' => 'Đã hoàn tiền',
                                                    'class' => 'primary',
                                                    'icon' => 'fas fa-wallet',
                                                ],
                                            ];
                                        @endphp
                                        @forelse ($recentOrders as $order)
                                            @php
                                                $status = $statusMap[$order->status] ?? [
                                                    'label' => 'Không rõ',
                                                    'class' => 'dark',
                                                    'icon' => 'fas fa-question-circle',
                                                ];
                                            @endphp
                                            <tr class="text-center">
                                                <td class="fw-semibold">{{ $order->order_code ?? '#' . $order->id }}</td>
                                                <td>{{ $order->user?->name ?? 'Không xác định' }}</td>
                                                <td class="text-success fw-semibold">
                                                    {{ number_format($order->total_price, 0, ',', '.') }}₫
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $status['class'] }} rounded-pill px-3 py-2">
                                                        <i class="{{ $status['icon'] }} me-1"></i>{{ $status['label'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-muted text-center py-4">Không có đơn hàng gần
                                                    đây.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Top sản phẩm bán chạy -->
                <div class="col-md-6">
                    <div class="card shadow-sm rounded-4 h-100">
                        <div class="card-header fw-bold bg-light d-flex align-items-center">
                            <i class="fas fa-fire me-2 text-danger"></i>Top sản phẩm bán chạy
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($topProducts as $item)
                                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="text-muted">
                                                <i class="fas fa-box-open fa-lg"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold text-truncate" style="max-width: 200px;">
                                                    {{ $item->name }}
                                                </div>
                                                <small class="text-muted">Đã bán: {{ $item->total_sold }}</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-success rounded-pill px-3 py-1">
                                            {{ $item->total_sold }} sản phẩm
                                        </span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted text-center py-4">Chưa có dữ liệu.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($revenueLabels) !!},
                        datasets: [{
                            label: 'Doanh thu (₫)',
                            data: {!! json_encode($revenueData) !!},
                            borderColor: '#4caf50',
                            backgroundColor: 'rgba(76, 175, 80, 0.2)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#4caf50'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ctx.dataset.label + ': ' +
                                        new Intl.NumberFormat('vi-VN').format(ctx.parsed.y) + '₫'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: value => new Intl.NumberFormat('vi-VN').format(value) + '₫'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
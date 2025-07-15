@extends('admin.layouts.default')

@section('content')
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 text-primary">
                    <i class="fas fa-ticket-alt me-2"></i>Danh sách Voucher
                </h4>
                <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary rounded-pill">
                    <i class="fas fa-plus me-1"></i> Thêm Voucher
                </a>
            </div>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-nowrap text-center">
                            <th>#</th>
                            <th>Mã</th>
                            <th>Loại</th>
                            <th>Giá trị</th>
                            <th>Đơn tối thiểu</th>
                            <th>Đã dùng / Giới hạn</th>
                            <th>Thời gian áp dụng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vouchers as $voucher)
                        <tr class="text-center">
                            <td>{{ $voucher->id }}</td>

                            <td>
                                <span class="fw-bold text-success">{{ $voucher->code }}</span>
                            </td>

                            <td>
                                <span class="badge bg-info">
                                    {{ $voucher->discount_type === 'percent' ? 'Giảm %' : 'Giảm cố định' }}
                                </span>
                            </td>

                            <td>
                                @if($voucher->discount_type === 'percent')
                                <span class="text-primary">{{ $voucher->discount_percent }}%</span>
                                @if($voucher->max_discount_amount)
                                <br>
                                <small class="text-muted fst-italic">
                                    Tối đa {{ number_format($voucher->max_discount_amount, 0, ',', '.') }}đ
                                </small>
                                @endif
                                @else
                                <span class="text-primary">
                                    {{ number_format($voucher->discount_amount, 0, ',', '.') }}đ
                                </span>
                                @endif
                            </td>

                            <td>
                                @if($voucher->min_order_amount)
                                {{ number_format($voucher->min_order_amount, 0, ',', '.') }}đ
                                @else
                                <span class="text-muted">Không yêu cầu</span>
                                @endif
                            </td>

                            <td>
                                {{ $voucher->users_count }} /
                                {{ $voucher->usage_limit ?? '∞' }}
                            </td>

                            <td>
                                @if($voucher->start_at && $voucher->end_at)
                                {{ $voucher->start_at->format('d/m/Y') }}
                                <br>
                                <span class="text-muted">đến</span>
                                <br>
                                {{ $voucher->end_at->format('d/m/Y') }}
                                @else
                                <span class="text-muted">Không giới hạn</span>
                                @endif
                            </td>

                            <td>
                                @php
                                $statuses = [
                                'active' => ['text' => 'Đang hoạt động', 'class' => 'success', 'icon' =>
                                'check-circle'],
                                'inactive' => ['text' => 'Tạm ngưng', 'class' => 'secondary', 'icon' => 'pause-circle'],
                                'expired' => ['text' => 'Hết hạn', 'class' => 'danger', 'icon' => 'times-circle'],
                                'used_up' => ['text' => 'Đã dùng hết', 'class' => 'warning', 'icon' => 'ban'],
                                ];

                                $current = $statuses[$voucher->status] ?? ['text' => 'Không rõ', 'class' => 'light',
                                'icon' => 'question-circle'];
                                @endphp

                                @if(in_array($voucher->status, ['expired', 'used_up']))
                                <span class="badge bg-{{ $current['class'] }} rounded-pill py-2 px-3">
                                    <i class="fas fa-{{ $current['icon'] }} me-1"></i>{{ $current['text'] }}
                                </span>
                                @else
                                <form action="{{ route('admin.vouchers.toggleStatus', $voucher->id) }}" method="POST"
                                    class="d-inline-block">
                                    @csrf
                                    @method('PATCH')

                                    <div class="dropdown">
                                        <button
                                            class="badge bg-{{ $current['class'] }} rounded-pill border-0 dropdown-toggle py-2 px-3"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-{{ $current['icon'] }} me-1"></i>{{ $current['text'] }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($statuses as $key => $value)
                                            @if($key !== $voucher->status && !in_array($key, ['expired', 'used_up']))
                                            <li>
                                                <button class="dropdown-item" type="submit" name="status"
                                                    value="{{ $key }}">
                                                    <i
                                                        class="fas fa-{{ $value['icon'] }} me-2 text-{{ $value['class'] }}"></i>
                                                    {{ $value['text'] }}
                                                </button>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </form>
                                @endif
                            </td>



                            <td>
                                <a href="{{ route('admin.vouchers.edit', $voucher->id) }}"
                                    class="btn btn-sm btn-warning rounded-pill me-1">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.vouchers.delete', $voucher->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-pill">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-ticket-alt fa-2x d-block mb-2"></i>
                                Không có voucher nào
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $vouchers->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
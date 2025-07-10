@extends('admin.layouts.default')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 text-primary"><i class="fas fa-ticket-alt me-2"></i>Danh sách Voucher</h4>
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
                        <tr>
                            <th>#</th>
                            <th>Mã</th>
                            <th>Kiểu giảm</th>
                            <th>Giá trị</th>
                            <th>Đã dùng / Giới hạn</th>
                            <th>Thời gian áp dụng</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vouchers as $voucher)
                        <tr>
                            <td>{{ $voucher->id }}</td>
                            <td><span class="fw-bold text-success">{{ $voucher->code }}</span></td>

                            <td>
                                <span class="badge bg-info">
                                    {{ $voucher->discount_type === 'percent' ? '%' : 'VNĐ' }}
                                </span>
                            </td>

                            <td>
                                @if($voucher->discount_type === 'percent')
                                <span class="text-primary">{{ $voucher->discount_percent }}%</span>
                                @else
                                <span
                                    class="text-primary">{{ number_format($voucher->discount_amount, 0, ',', '.') }}đ</span>
                                @endif
                            </td>

                            <td>
                                {{ $voucher->users_count }} /
                                {{ $voucher->usage_limit ?? '∞' }}
                            </td>

                            <td>
                                @if($voucher->start_at && $voucher->end_at)
                                {{ \Carbon\Carbon::parse($voucher->start_at)->format('d/m/Y') }}
                                -
                                {{ \Carbon\Carbon::parse($voucher->end_at)->format('d/m/Y') }}
                                @else
                                <span class="text-muted">Không giới hạn</span>
                                @endif
                            </td>

                            <td>
                                @switch($voucher->status)
                                @case('active')
                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Đang hoạt
                                    động</span>
                                @break
                                @case('inactive')
                                <span class="badge bg-secondary"><i class="fas fa-pause-circle me-1"></i>Tạm
                                    ngưng</span>
                                @break
                                @case('expired')
                                <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Hết hạn</span>
                                @break
                                @default
                                <span class="badge bg-light">Không rõ</span>
                                @endswitch
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.vouchers.edit', $voucher->id) }}"
                                    class="btn btn-sm btn-warning rounded-pill">
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
                            <td colspan="8" class="text-center text-muted">Không có voucher nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $vouchers->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
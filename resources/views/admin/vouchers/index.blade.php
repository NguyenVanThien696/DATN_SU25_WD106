@extends('admin.layouts.default')

@section('content')
<div class="container mt-4">
    <h2>Danh sách Voucher</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary mb-3">Thêm Voucher</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã</th>
                <th>Kiểu giảm</th>
                <th>Giá trị</th>
                <th>Đã dùng / Giới hạn</th>
                <th>Thời gian áp dụng</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vouchers as $voucher)
                <tr>
                    <td>{{ $voucher->id }}</td>
                    <td>{{ $voucher->code }}</td>

                    <td>
                        @if($voucher->discount_type === 'percent')
                            %
                        @elseif($voucher->discount_type === 'amount')
                            VNĐ
                        @endif
                    </td>

                    <td>
                        @if($voucher->discount_type === 'percent')
                            {{ $voucher->discount_percent }}%
                        @elseif($voucher->discount_type === 'amount')
                            {{ number_format($voucher->discount_amount, 0, ',', '.') }}đ
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
                            Không giới hạn
                        @endif
                    </td>

                    <td>
                        @switch($voucher->status)
                            @case('active')
                                <span class="badge bg-success">Đang hoạt động</span>
                                @break
                            @case('inactive')
                                <span class="badge bg-secondary">Tạm ngưng</span>
                                @break
                            @case('expired')
                                <span class="badge bg-danger">Hết hạn</span>
                                @break
                            @default
                                <span class="badge bg-light">Không rõ</span>
                        @endswitch
                    </td>

                    <td>
                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('admin.vouchers.delete', $voucher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xoá</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $vouchers->links() }}
</div>
@endsection

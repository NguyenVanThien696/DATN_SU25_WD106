@extends('admin.layouts.default')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Chi tiết yêu cầu hoàn tiền</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <strong>Thông tin khách hàng</strong>
                </div>
                <div class="card-body">
                    <p><strong>Tên:</strong> {{ $refundRequest->user->name }}</p>
                    <p><strong>Email:</strong> {{ $refundRequest->user->email }}</p>
                </div>
            </div>

            @if($refundRequest->order)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <strong>Thông tin đơn hàng</strong>
                </div>
                <div class="card-body">
                    <p><strong>Mã đơn:</strong> #{{ $refundRequest->order->order_code }}</p>
                    <p><strong>Trạng thái:</strong> {{ $refundRequest->order->status }}</p>
                    <p><strong>Tổng tiền:</strong> {{ number_format($refundRequest->order->total_price, 0, ',', '.') }}đ
                    </p>
                    <a href="{{ route('admin.order.detail', $refundRequest->order->id) }}"
                        class="btn btn-sm btn-outline-primary mt-2">
                        <i class="bi bi-eye"></i> Xem đơn hàng
                    </a>
                </div>
            </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <strong>Lý do hoàn tiền</strong>
                </div>
                <div class="card-body">
                    <p>{{ $refundRequest->reason ?? '(Không có ghi chú)' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <span><strong>Minh chứng</strong></span>
                    <span class="badge 
                        @if($refundRequest->status === 'pending') bg-warning text-dark
                        @elseif($refundRequest->status === 'approved') bg-success
                        @else bg-danger @endif">
                        @if($refundRequest->status === 'pending') Chờ xử lý
                        @elseif($refundRequest->status === 'approved') Đã duyệt
                        @else Từ chối @endif
                    </span>
                </div>
                <div class="card-body text-center">
                    @if($refundRequest->image)

                    <a href="{{ asset('storage/' . $refundRequest->image) }}" target="_blank">
                        <img src="{{ asset('storage/' . $refundRequest->image) }}" alt="Ảnh minh chứng"
                            class="img-thumbnail w-25">
                    </a>
                    @else
                    <p>Không có ảnh minh chứng.</p>
                    @endif
                </div>
            </div>

            @if($refundRequest->status === 'pending')
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <strong>Hành động</strong>
                </div>
                <div class="card-body">
                    @if($refundRequest->status === 'pending')
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <strong>Hành động</strong>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.wallet.refund-requests.update', $refundRequest->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="status" class="form-label">Chọn hành động</label>
                                    <select name="status" id="status" class="form-select" required
                                        onchange="togglePasswordField(this.value)">
                                        <option value="">-- Chọn --</option>
                                        <option value="approved">Duyệt hoàn tiền</option>
                                        <option value="rejected">Từ chối</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="passwordField" style="display: none;">
                                    <label for="admin_password" class="form-label">Mật khẩu admin</label>
                                    <input type="password" name="admin_password" id="admin_password"
                                        class="form-control" placeholder="Nhập mật khẩu để xác nhận duyệt hoàn tiền">
                                </div>

                                <button type="submit" class="btn btn-success me-2">Xác nhận</button>
                                <a href="{{ route('admin.wallet.refund-requests.index') }}"
                                    class="btn btn-secondary">Quay lại</a>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('admin.wallet.refund-requests.index') }}" class="btn btn-secondary w-100">Quay lại
                        danh sách</a>
                    @endif

                </div>
            </div>
            @else
            <a href="{{ route('admin.wallet.refund-requests.index') }}" class="btn btn-secondary w-100">Quay lại danh
                sách</a>
            @endif
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function togglePasswordField(value) {
    const field = document.getElementById('passwordField');
    field.style.display = (value === 'approved') ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('status');
    if (select) togglePasswordField(select.value);
});
</script>
@endpush
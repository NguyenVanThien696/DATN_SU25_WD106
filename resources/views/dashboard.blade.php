@extends('client.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Thông tin người dùng -->
        <div class="col-md-4 mb-4">
            <div class="card p-4 text-center shadow-sm" style="border-radius: 16px;">
                <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center bg-light border shadow"
     style="width: 100px; height: 100px;">
    <i class="fas fa-user fa-2x text-secondary"></i>
</div>
                <h5 class="mb-1 text-capitalize">{{ Auth::user()->name }}</h5>

                <div class="text-start mt-3">
                    <p class="mb-2"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p class="mb-2"><strong>Phone:</strong> {{ Auth::user()->phone ?? 'Chưa cập nhật' }}</p>
                    <p class="mb-2"><strong>Tài khoản:</strong> {{ Auth::user()->username ?? Auth::user()->name }}</p>
                    <p class="mb-2"><strong>Số dư:</strong> {{ number_format(Auth::user()->balance ?? 0) }} VND</p>
                    <p class="mb-0"><strong>Ngày tạo:</strong> {{ Auth::user()->created_at->format('Y-m-d H:i:s') }}</p>
                </div>

                <a href="#" class="btn btn-primary w-100 mt-4 py-2" style="border-radius: 30px;">
                    + Nạp tiền tài khoản
                </a>

                <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-danger w-100 mt-2 py-2" style="border-radius: 30px;">
        Đăng xuất
    </button>
</form>
            </div>
            
        </div>

        <!-- Form đổi mật khẩu -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm" style="border-radius: 16px;">
                <h5 class="mb-4 text-primary">Đổi Mật Khẩu</h5>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('user.changePassword') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Mật khẩu cũ</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Nhập lại mật khẩu mới</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2" style="border-radius: 30px;">Đổi ngay</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

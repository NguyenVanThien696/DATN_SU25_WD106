@extends('client.master')

@section('content')
    <div class="container d-flex justify-content-center mt-5">
        <div class="w-100" style="max-width: 500px;">
            {{-- Tiêu đề --}}
            <h3 class="text-center mb-4">Đăng nhập tài khoản</h3>

            {{-- Thông báo chung (nếu có) --}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->has('login_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.form') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Địa chỉ email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mật khẩu --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <div class="position-relative">
                        <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror"
                            id="password" name="password">
                        <span onclick="togglePassword()" style="
                                                    position: absolute;
                                                    top: 50%;
                                                    right: 15px;
                                                    transform: translateY(-50%);
                                                    cursor: pointer;">
                            👁
                        </span>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Ghi nhớ đăng nhập và Quên mật khẩu --}}
                <div class="mb-3 row align-items-center">
                    <div class="col d-flex align-items-center">
                        <input type="checkbox" id="remember" name="remember" class="form-check-input me-2">
                        <label for="remember" class="form-check-label">Ghi nhớ đăng nhập</label>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('password.request') }}" class="text-primary fw-semibold"
                            style="text-decoration: none;">
                            Quên mật khẩu?
                        </a>
                    </div>
                </div>

                {{-- Nút đăng nhập --}}
                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>

                <div class="text-center mt-3">
                    Bạn chưa có tài khoản?
                    <a href="{{ route('register.form') }}" class="text-primary fw-semibold">Đăng ký</a>.
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
@endpush
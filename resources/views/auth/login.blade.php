@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="w-100" style="max-width: 500px;">
        {{-- Tiêu đề --}}
        <h3 class="text-center mb-4">Đăng nhập tài khoản</h3>

        <form method="POST" action="{{ route('login.form') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Địa chỉ email</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>

            {{-- Mật khẩu --}}
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="position-relative">
                    <input type="password" class="form-control pe-5" id="password" name="password">
                    <span onclick="togglePassword()" style="
                        position: absolute;
                        top: 50%;
                        right: 15px;
                        transform: translateY(-50%);
                        cursor: pointer;
                        display: inline-block;
                        line-height: 1;
                    ">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                             viewBox="0 0 16 16" style="opacity: 0.5;">
                            <path d="M13.359 11.238a8.637 8.637 0 0 0 2.328-3.012.5.5 0 0 0 0-.452C14.938 5.255 12.313 3 8 3 6.386 3 5.063 3.396 4.027 4.062l.844.844C5.738 4.312 6.794 4 8 4c3.313 0 5.625 2.255 6.734 3.774a7.644 7.644 0 0 1-2.063 2.519l.688.945zM3.646 2.354a.5.5 0 0 0-.708.708l1.523 1.523A7.69 7.69 0 0 0 1.91 7.774a.5.5 0 0 0 0 .452C3.063 10.745 5.687 13 10 13c1.002 0 1.938-.197 2.773-.555l1.581 1.581a.5.5 0 0 0 .708-.708l-12-12zm3.74 5.156 1.103 1.103a1.5 1.5 0 0 1-1.103-1.103zm1.962 2.877-2.093-2.093a1.5 1.5 0 0 1 2.093 2.093zm.708.708a1.5 1.5 0 0 1-2.093-2.093l2.093 2.093z"/>
                        </svg>
                    </span>
                </div>
            </div>

            {{-- Ghi nhớ đăng nhập --}}
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
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

{{-- Script toggle mật khẩu --}}
@push('scripts')
<script>
function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");
    if (input.type === "password") {
        input.type = "text";
        icon.style.opacity = 1;
    } else {
        input.type = "password";
        icon.style.opacity = 0.5;
    }
}
</script>
@endpush

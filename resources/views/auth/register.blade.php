@extends('client.master')

@section('content')
<style>
    .register-form-wrapper {
        max-width: 480px;
        margin: 0 auto;
        background-color: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }

    .register-form-wrapper h3 {
        text-align: center;
        font-weight: bold;
        margin-bottom: 25px;
    }

    label {
        font-weight: 500;
    }
</style>

<div class="container py-5">
    <div class="register-form-wrapper">
        <h3>Đăng ký tài khoản</h3>
        <form method="POST" action="{{ route('register.form') }}">
            @csrf

            {{-- Họ tên --}}
            <div class="mb-3">
                <label for="name" class="form-label">Họ tên</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            {{-- Mật khẩu --}}
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            {{-- Xác nhận mật khẩu --}}
            <div class="mb-4">
                <label for="password-confirm" class="form-label">Xác nhận mật khẩu</label>
                <input id="password-confirm" type="password" class="form-control"
                       name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
        </form>
    </div>
</div>
@endsection

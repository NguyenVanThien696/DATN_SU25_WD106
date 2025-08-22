@extends('client.master')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
    <style>
        .register-form-wrapper {
            max-width: 480px;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
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
            <h3>Quên mật khẩu</h3>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Gửi liên kết đặt lại mật khẩu</button>
            </form>
        </div>
    </div>
@endsection
@extends('client.master')

@section('content')
    <style>
        .reset-password-form {
            max-width: 500px;
            margin: 60px auto;
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.05);
        }

        .reset-password-form h3 {
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 15px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-weight: 500;
            border-radius: 8px;
        }

        .form-error {
            font-size: 14px;
            color: red;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-weight: 500;
            border-radius: 8px;
            margin-top: 20px;
            /* thêm dòng này */
        }
    </style>

    <div class="container">
        <div class="reset-password-form">
            <h3>Đặt lại mật khẩu</h3>

            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $err)
                        <div>{{ $err }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request()->email }}">

                <div class="form-group">
                    <label for="password">Mật khẩu mới</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Đặt lại mật khẩu</button>

            </form>


        </div>
    </div>
@endsection
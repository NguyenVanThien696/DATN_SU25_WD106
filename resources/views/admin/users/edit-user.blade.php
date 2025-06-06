@extends('admin.layouts.default')

@section('content')
<div class="container">
    <h2>Chỉnh sửa người dùng</h2>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Họ tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
        </div>

        <div class="mb-3">
            <label>Số dư</label>
            <input type="number" name="balance" class="form-control" value="{{ old('balance', $user->balance) }}">
        </div>

        <div class="mb-3">
            <label>Vai trò</label>
            <select name="role" class="form-control">
                <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>User</option>
                <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection

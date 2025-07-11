@extends('admin.layouts.default')

@section('title', 'Chỉnh sửa người dùng')

@push('styles')
    <style>
        .form-label {
            font-weight: 500;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Chỉnh sửa người dùng</h5>
                    </div>

                    <div class="card-body">

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
                                <label class="form-label">Họ tên</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', $user->phone) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vai trò</label>
                                @if ($user->role == 1 && Auth::id() !== $user->id)
                                    {{-- Không cho sửa role của Admin khác --}}
                                    <input type="text" class="form-control" value="Admin" disabled>
                                    <input type="hidden" name="role" value="1">
                                @else
                                    <select name="role" class="form-select">
                                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>User</option>
                                        <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>Staff</option>
                                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                                    </select>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.users') }}" class="btn btn-secondary px-4">← Quay lại</a>
                                <button type="submit" class="btn btn-success px-4">Lưu thay đổi</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
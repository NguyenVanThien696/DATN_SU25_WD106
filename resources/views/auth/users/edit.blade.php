@extends('client.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Form cập nhật thông tin -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm" style="border-radius: 16px;">
                <h5 class="mb-4 text-primary">Cập nhật thông tin</h5>

                @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Họ Tên</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $user->address) }}">
                        @error('address')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ảnh đại diện</label>
                        <input type="file" name="avatar" class="form-control">
                        @error('avatar')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror

                        @if ($user->avatar)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $user->avatar) }}" width="100" class="rounded"
                                alt="Avatar hiện tại">
                        </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2" style="border-radius: 30px;">Cập
                        nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
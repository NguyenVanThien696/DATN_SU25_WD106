@extends('client.master')

@section('content')
<main class="p-6 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Thông tin người dùng -->
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex flex-col items-center space-y-4">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 text-sm">
                    100x100
                </div>
                <h2 class="text-lg font-semibold">{{ $user->name }}</h2>
            </div>
            <div class="mt-6 space-y-2 text-sm">
                <div><strong>Email:</strong> {{ $user->email }}</div>
                <div><strong>Phone:</strong> {{ $user->phone ?? 'Chưa cập nhật' }}</div>
                <div><strong>Tài khoản:</strong> {{ $user->name }}</div>
                <div><strong>Số dư:</strong> <span class="text-red-500 font-semibold">{{ number_format($user->balance) }} VNĐ</span></div>
                <div><strong>Ngày tạo:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}</div>
            </div>
            <div class="mt-6">
                <a href="{{ route('topup') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    + Nạp tiền tài khoản
                </a>
            </div>
        </div>

        <!-- Form đổi mật khẩu -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold mb-4">Đổi Mật Khẩu</h2>
            <form action="{{ route('user.changePassword') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <input type="password" name="old_password" placeholder="Mật khẩu cũ" class="w-full p-3 border rounded-md" />
                </div>
                <div>
                    <input type="password" name="new_password" placeholder="Mật khẩu mới" class="w-full p-3 border rounded-md" />
                </div>
                <div>
                    <input type="password" name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới" class="w-full p-3 border rounded-md" />
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded hover:bg-blue-600 transition">
                    Đổi ngay
                </button>
            </form>
        </div>
    </div>
</main>
@endsection

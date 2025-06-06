@extends('admin.layouts.default')

@section('styles')
<style>
    /* Font tiêu đề */
    h2.custom-title {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: 700;
        font-size: 1.8rem;
        color: #333;
    }

    /* Form tìm kiếm */
    form.search-form {
        max-width: 320px;
    }

    form.search-form input[type="text"] {
        border-radius: 25px 0 0 25px;
        padding-left: 15px;
        font-size: 0.9rem;
        border: 1px solid #ced4da;
        transition: border-color 0.3s ease;
        height: 38px;
    }

    form.search-form input[type="text"]:focus {
        border-color: #495057;
        outline: none;
        box-shadow: 0 0 6px rgba(73,80,87,0.5);
    }

    form.search-form button {
        border-radius: 0 25px 25px 0;
        border: 1px solid #ced4da;
        border-left: none;
        background-color: #6c757d;
        color: white;
        width: 42px;
        height: 38px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    form.search-form button:hover {
        background-color: #5a6268;
    }

    form.search-form button i {
        font-size: 1.1rem;
    }

    /* Nút Xóa */
    .btn-danger.custom-delete-btn {
        background-color: #f8d7da; /* đỏ nhạt */
        color: #842029;
        border: 1px solid #f5c2c7;
        border-radius: 6px;
        padding: 4px 12px;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-danger.custom-delete-btn:hover {
        background-color: #dc3545; /* đỏ đậm */
        color: white;
        border-color: #dc3545;
        text-decoration: none;
    }

    .btn-danger.custom-delete-btn i {
        font-size: 1rem;
    }
    
</style>
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="custom-title mb-0">Danh sách tài khoản người dùng</h2>

        <!-- Ô tìm kiếm -->
        <form method="GET" action="{{ route('admin.users') }}" class="search-form d-flex" role="search" autocomplete="off">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm tên hoặc email...">
            <button type="submit" aria-label="Tìm kiếm">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Username</th>
                <th>Số dư</th>
                <th>Vai trò</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? 'Chưa có' }}</td>
                <td>{{ $user->username ?? 'N/A' }}</td>
                <td>{{ number_format($user->balance ?? 0) }} VND</td>
                <td>
                    <span class="badge {{ $user->role == 1 ? 'bg-success' : 'bg-secondary' }}">
                        {{ $user->role == 1 ? 'Admin' : 'User' }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                <td class="d-flex gap-1">
                    <!-- Nút sửa -->
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1">
                        <i class="fas fa-edit"></i> Sửa
                    </a>

                    <!-- Nút xóa -->
                    @if(Auth::user()->role == 1 && Auth::id() != $user->id)
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger custom-delete-btn" >
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Phân trang -->
    {{ $users->withQueryString()->links() }}
</div>
@endsection

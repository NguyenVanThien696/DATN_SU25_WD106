@extends('admin.layouts.default')

@section('title', 'Quản lý người dùng')

@push('styles')
    <style>
        .table th,
        .table td {
            vertical-align: middle !important;
            white-space: nowrap;
        }

        .table th {
            background-color: #f1f3f5;
        }

        .badge {
            font-size: 0.85em;
            padding: 0.4em 0.6em;
            border-radius: 0.25rem;
        }

        .search-form {
            max-width: 320px;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 text-primary">Danh sách người dùng</h4>
            <form class="d-flex search-form" action="{{ route('admin.users') }}" method="GET">
                <input type="text" class="form-control me-2" name="search" value="{{ request('search') }}"
                    placeholder="Tìm tên hoặc email...">
                <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
            </form>
        </div>

        @if (session('status'))
            <div class="alert alert-success mb-3">{{ session('status') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif

        <div class="table-responsive shadow rounded">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '—' }}</td>
                            <td class="text-center">
                                @if ($user->role == 1)
                                    <span class="badge bg-success"><i class="fas fa-user-shield"></i> Admin</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fas fa-user"></i> Người dùng</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning px-3">
                                    <i class="fas fa-edit me-1"></i> Sửa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Không có người dùng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
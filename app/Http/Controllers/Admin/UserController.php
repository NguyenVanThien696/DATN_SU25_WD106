<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
 public function index(Request $request)
{
    $users = User::orderBy('id', 'desc')->paginate(10)->appends($request->query());
    return view('admin.users.index', compact('users'));
}

public function seachs(Request $request)
{
    // Khởi tạo query builder từ model User
    $query = User::query();

    // Nếu có từ khóa tìm kiếm
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Phân trang + giữ lại query string ?search=...
    $users = $query->orderBy('id', 'desc')
                   ->paginate(10)
                   ->appends($request->query()); // dùng appends thay vì withQueryString()

    return view('admin.users.index', compact('users'));
}




    
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'phone' => 'nullable|string|max:20',
            'username' => 'nullable|string|max:50',
            'balance' => 'nullable|numeric|min:0',
            'role' => 'required|in:0,1',
        ]);

        $user->update($request->only('name', 'email', 'phone', 'username', 'balance', 'role'));

        return redirect()->route('admin.users')->with('status', 'Cập nhật người dùng thành công!');
    }

    public function destroy(User $user)
    {
        // Không cho xoá chính mình
       if (Auth::id() == $user->id) {
        return back()->with('error', 'Bạn không thể tự xoá chính mình!');
}

        $user->delete();
        return back()->with('status', 'Xoá người dùng thành công!');
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            switch ((int)$user->role) {
                case 1: // Admin
                    return redirect()->route('admin.dashboard');

                default: // User thường
                    return redirect()->route('dashboard.form');
            }
        }
        return redirect()->back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showDashboard()
    {
        $user = Auth::user();
        if (is_null($user)) {
            return redirect()->route('login.form');
        }
        return view('dashboard', ['user' => $user]);
    }



public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    Auth::login($user);

    return redirect()->route('dashboard.form');
}


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu cũ không đúng.'])->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        session()->put('status', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại.');
        Auth::logout();

        return redirect()->route('login.form')->with('status', 'Đổi mật khẩu thành công, vui lòng đăng nhập lại.');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

public function adminIndex()
{
    $user = Auth::user();
    if (is_null($user) || (int) $user->role !== 1) {
        return redirect()->route('login.form');
    }

    // Lấy đơn mới
    $newOrders = Order::where('status', 'pending')
        ->where('is_seen_by_admin', false)
        ->orderByDesc('created_at')
        ->get();

    // Lấy đơn hoàn chưa xem
    $refundOrders = Order::where('status', 'refunded')
        ->where('is_seen_by_admin', false)
        ->orderByDesc('created_at')
        ->get();

    // Gộp lại
    $allNewOrders = $newOrders->merge($refundOrders);

    // Tổng số thông báo
    $totalNotifications = $allNewOrders->count();

    // Cập nhật đã xem
    Order::whereIn('id', $allNewOrders->pluck('id'))->update(['is_seen_by_admin' => true]);

    return view('admin.index', [
        'user' => $user,
        'newOrders' => $allNewOrders,
        'totalNotifications' => $totalNotifications
    ]);
}



    public function adminDashboard()
    {
        $user = Auth::user();
        if (is_null($user) || (int) $user->role != 1) {
            // Nếu không phải admin hoặc chưa đăng nhập, chuyển về login hoặc trang khác
            return redirect()->route('login.form');
        }
        return view('admin.dashboard', ['user' => $user]);
    }

public function edit(Request $request)
{
    $user = Auth::user();

    return view('auth.users.edit', compact('user'));
}

public function update(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'phone' => 'required|numeric',
        'address' => 'required|string|max:255',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->phone = $validated['phone'];
    $user->address = $validated['address'];

    if ($request->hasFile('avatar')) {
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $avatarPath;
    }

    $user->save();

    return redirect()->route('dashboard.form')->with('status', 'Cập nhật thông tin thành công.');
}
}
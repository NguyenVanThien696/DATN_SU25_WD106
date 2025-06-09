<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm(){
        return view ('auth.login');
    }

        public function login(Request $request){
            $credentials = $request->only('email', 'password');

            if(Auth::attempt($credentials)){
                $user = Auth::user();
                if($user->role==1){
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('dashboard');
            }
            return redirect()->back()->withErrors([
                'email' => 'Thông tin đăng nhập không chính xác.',
            ]);
        }

    public function showRegisterForm(){
        return view ('auth.register');
    }

    public function showDashboard(){
        $user = Auth::user();
        if(is_null($user)){
            return redirect()->route('login.form');
        }
        return view('dashboard', ['user' => $user]);
    }

    public function adminDashboard()
{
    $user = Auth::user();
    if (is_null($user) || $user->role != 1) {
        // Nếu không phải admin hoặc chưa đăng nhập, chuyển về login hoặc trang khác
        return redirect()->route('login.form');
    }
    return view('admin.dashboard', ['user' => $user]);
}

    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Auth::attempt([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ]);

        return redirect()->route('dashboard');
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
}
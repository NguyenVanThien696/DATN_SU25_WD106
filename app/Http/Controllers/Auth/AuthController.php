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
            return redirect()->route('dashboard.form');
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

    public function changePassword(Request $request){
        $user = Auth::user();

        Log::info('Mật khẩu cũ trong cơ sở dữ liệu:', ['stored_password' => $user->password]);
        Log::info('Mật khẩu cũ người dùng nhập vào:', ['current_password' => $request->current_password]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu cũ không đúng.']);
        }

        DB::table('users')
            ->where('id', $user->id)
            ->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('dashboard')->with('status', 'Mật khẩu đã được thay đổi thành công.');
    }
}
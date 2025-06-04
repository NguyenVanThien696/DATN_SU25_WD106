<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm(){
        return view ('auth.login');
    }

    // public function login(Request $request){
    //     $credentials = $request->only('email', 'password');

    //     if(Auth::attempt($credentials)){
    //         $user = Auth::user();
    //         if($user->role==1){
    //             return redirect()->route('client.index');
    //         }
    //     }
    // }

    public function showRegisterForm(){
        return view ('auth.register');
    }

    public function showDashboard(){
        return view ('dashboard');
    }
}
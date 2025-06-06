<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}
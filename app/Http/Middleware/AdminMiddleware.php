<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
           dump("Đang chạy middleware Admin");
    dump('Role:', $user?->role);
    dump('So sánh:', (int)trim($user?->role) === 1);

        if (!$user || (int)trim($user->role) !== 1) {
            return redirect()->route('login.form')->withErrors(['Bạn không có quyền truy cập trang này.']);
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || (int) $user->role !== 3) {
            return redirect()->route('login.form')->withErrors(['Bạn không có quyền truy cập trang này.']);
        }

        return $next($request);
    }
}

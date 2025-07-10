<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Nếu chưa đăng nhập, chuyển về trang đăng nhập
        if (!$user) {
            return redirect()->route('login.form');
        }

        // Nếu đã đăng nhập nhưng không phải admin
        if ((int) $user->role !== 1) {
            abort(403); // hoặc abort(403) nếu bạn muốn hiện trang "Cấm truy cập"
        }

        return $next($request);
    }
}

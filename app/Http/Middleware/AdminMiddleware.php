<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    // Xử lý request trước khi vào route
    public function handle(Request $request, Closure $next)
    {
        // chưa login -> chuyển hướng về login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Bạn cần đăng nhập');
        }

        // 0 phải admin -> chuyển hướng về home
        if (Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Không có quyền truy cập');
        }

        // là admin -> cho qua
        return $next($request);
    }
}
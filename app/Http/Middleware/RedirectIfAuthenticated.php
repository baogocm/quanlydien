<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('nhanvien')) {
            return redirect()->route('dashboard')->with('error', 'Bạn đã đăng nhập, không thể truy cập trang đăng nhập.');
        }

        return $next($request);
    }
} 
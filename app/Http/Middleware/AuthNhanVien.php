<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthNhanVien
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('nhanvien')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
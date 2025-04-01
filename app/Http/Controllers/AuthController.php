<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NhanVien;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'tk' => 'required',
            'mk' => 'required',
        ]);

        $nhanVien = NhanVien::where('tk', $request->tk)->first();

        if ($nhanVien && $nhanVien->mk === $request->mk) {
            Session::put('nhanvien', $nhanVien);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'tk' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function logout()
    {
        Session::forget('nhanvien');
        return redirect('/');
    }
}
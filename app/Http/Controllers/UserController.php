<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'manv' => 'required|unique:nhanvien,manv',
            'tennv' => 'required',
            'ngaysinh' => 'required|date',
            'chucvu' => 'required',
            'tk' => 'required|unique:nhanvien,tk',
            'mk' => 'required',
            'phai' => 'required|in:Nam,Nữ',
            'luong' => 'required|numeric|min:0',
            'sdt' => 'required'
        ]);

        NhanVien::create($request->all());

        return redirect()->back()->with('success', 'Thêm nhân viên thành công!');
    }

    public function update(Request $request, $manv)
    {
        $request->validate([
            'chucvu' => 'required|in:Nhân Viên,Admin'
        ]);

        $nhanvien = NhanVien::findOrFail($manv);
        $nhanvien->update([
            'chucvu' => $request->chucvu
        ]);

        return redirect()->back()->with('success', 'Cập nhật chức vụ thành công!');
    }

    public function destroy($manv)
    {
        $nhanvien = NhanVien::findOrFail($manv);
        $nhanvien->delete();

        return redirect()->back()->with('success', 'Xóa nhân viên thành công!');
    }

    public function changePassword(Request $request, $manv)
    {
        $request->validate([
            'mk' => 'required|confirmed',
        ]);

        $nhanvien = NhanVien::findOrFail($manv);
        $nhanvien->update(['mk' => $request->mk]);

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }
} 
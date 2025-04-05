<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NhanVien;
use App\Models\KhachHang;
use App\Models\DienKe;
use App\Models\BacGia;
use App\Models\HoaDon;
use App\Models\CTHoaDon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function index()
    {
        $hoadons = HoaDon::with(['chiTietHoaDon.dienKe.khachHang', 'nhanVien'])->get();
        $khachhangs = KhachHang::all();
        $nhanviens = NhanVien::all();
        
        return view('dashboard.index', compact('hoadons', 'khachhangs', 'nhanviens'));
    }

    /**
     * Display the customers page.
     */
    public function khachHang()
    {
        $khachhangs = KhachHang::all();
        return view('dashboard.khachhang', compact('khachhangs'));
    }

    /**
     * Display the electricity meters page.
     */
    public function dienKe()
    {
        $dienkes = DienKe::all();
        return view('dashboard.dienke', compact('dienkes'));
    }

    /**
     * Display the bills page.
     */
    public function hoaDon()
    {
        $hoadons = HoaDon::with(['chiTietHoaDon', 'nhanVien'])->get();
        $kys = HoaDon::distinct()->orderBy('ky')->pluck('ky');
        return view('dashboard.hoadon', compact('hoadons', 'kys'));
    }

    /**
     * Display the electricity rates page.
     */
    public function giaDien()
    {
        $bacgia = BacGia::all();
        return view('dashboard.giadien', compact('bacgia'));
    }

    /**
     * Display the users page.
     */
    public function users()
    {
        $nhanviens = NhanVien::all();
        return view('dashboard.users', compact('nhanviens'));
    }
}

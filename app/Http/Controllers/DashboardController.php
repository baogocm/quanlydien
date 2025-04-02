<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NhanVien;
use App\Models\KhachHang;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function index()
    {
        // TODO: Add real data from database
        return view('dashboard.index');
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
        return view('dashboard.dienke');
    }

    /**
     * Display the bills page.
     */
    public function hoaDon()
    {
        return view('dashboard.hoadon');
    }

    /**
     * Display the electricity rates page.
     */
    public function giaDien()
    {
        return view('dashboard.giadien');
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

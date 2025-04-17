<?php

namespace App\Http\Controllers;

use App\Models\KhachHang; // Nếu bạn có model khác cho khách hàng, hãy thay đổi theo đúng model
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'makh' => 'required|unique:khachhang,makh',  // Đổi từ manv thành makh
            'tenkh' => 'required',                       // Tên khách hàng
            'dt' => 'required',                          // Số điện thoại khách hàng
            'cmnd' => 'required|unique:khachhang,cmnd',  // CMND
        ]);

        // Thêm khách hàng mới
        KhachHang::create($request->all());  // Nếu bạn có model riêng cho KhachHang, thay 'KhachHang' thành 'KhachHang'

        return redirect()->back()->with('success', 'Thêm khách hàng thành công!');
    }

    public function update(Request $request, $makh)
    {
        $request->validate([
            'tenkh' => 'required',
            'dt' => 'required',
            'cmnd' => 'required|unique:khachhang,cmnd,' . $makh . ',makh', // Nếu cần update CMND, thêm điều kiện bỏ qua CMND cũ
        ]);

        $khachhang = KhachHang::findOrFail($makh); // Nếu model của bạn là KhachHang, thay 'KhachHang' thành 'KhachHang'
        $khachhang->update($request->all());

        return redirect()->back()->with('success', 'Cập nhật khách hàng thành công!');
    }

    public function destroy($makh)
    {
        $khachhang = KhachHang::findOrFail($makh);  // Thay 'KhachHang' thành 'KhachHang' nếu cần
        $khachhang->delete();

        return redirect()->back()->with('success', 'Xóa khách hàng thành công!');
    }
}

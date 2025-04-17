<?php

namespace App\Http\Controllers;

use App\Models\DienKe;
use Illuminate\Http\Request;

class DienKeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'madk' => 'required|unique:dienke,madk',
            'makh' => 'required|exists:khachhang,makh', // Đảm bảo khách hàng tồn tại
            'mota' => 'nullable|string',
        ]);
    
        // Thiết lập giá trị mặc định cho các trường nếu không được cung cấp trong request
        $data = $request->only(['madk', 'makh', 'mota','diachi']);
        $data['trangthai'] =  1; // Nếu không có, gán 'active'
        $data['cs_dau'] = 0; // Nếu không có 'cs_dau' trong request, gán là 0
        $data['cs_cuoi'] = 0; // Nếu không có 'cs_cuoi' trong request, gán là 0
        $data['ngaylap'] = now(+7); // Gán thời gian hiện tại cho 'ngaylap'
    
        // Tạo mới bản ghi trong bảng 'dienke'
        DienKe::create($data);
    
        return redirect()->back()->with('success', 'Thêm điện kế thành công!');
    }

    public function update(Request $request, $madk)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'cs_dau' => 'required|integer|min:0',
            'cs_cuoi' => 'required|integer|min:0|gte:cs_dau', // Đảm bảo cs_cuoi >= cs_dau
        ]);
    
        // Tìm điện kế cần cập nhật
        $dienke = DienKe::findOrFail($madk);
    
        // Cập nhật chỉ số đầu và chỉ số cuối
        $dienke->update([
            'cs_dau' => $request->input('cs_dau'),
            'cs_cuoi' => $request->input('cs_cuoi'),
        ]);
    
        // Trả về thông báo thành công
        return redirect()->back()->with('success', 'Cập nhật chỉ số điện kế thành công!');
    }
    public function updateTrangThai(Request $request, $madk)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'trangthai' => 'required|boolean',
        ]);
    
        // Tìm điện kế cần cập nhật
        $dienke = DienKe::findOrFail($madk);
    
        // Cập nhật chỉ số đầu và chỉ số cuối
        $dienke->update([
            'trangthai' => $request->input('trangthai'),
        ]);
    
        // Trả về thông báo thành công
        return redirect()->back()->with('success', 'Cập nhật trạng thái điện kế thành công!');
    }
    public function destroy($madk)
    {
        $dienke = DienKe::findOrFail($madk);
        $dienke->delete();

        return redirect()->back()->with('success', 'Xóa điện kế thành công!');
    }
}

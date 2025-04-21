<?php

namespace App\Http\Controllers;

use App\Models\DienKe;
use App\Models\HoaDon;
use App\Models\CTHoaDon;
use App\Models\KhachHang;
use App\Models\BacGia;
use App\Models\NhanVien;
use App\Models\VersionBacGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use Carbon\Carbon;

class DienKeController extends Controller
{
    /**
     * Tạo hóa đơn từ điện kế
     */
    public function taoHoaDon($madk)
    {
        try {
            DB::beginTransaction();

            // Lấy thông tin điện kế
            $dienKe = DienKe::findOrFail($madk);
            
            // Kiểm tra điều kiện tạo hóa đơn
            if ($dienKe->cs_dau >= $dienKe->cs_cuoi) {
                return redirect()->back()->with('error', 'Chỉ số điện không hợp lệ để tạo hóa đơn!');
            }
            
            if (!$dienKe->trangthai) {
                return redirect()->back()->with('error', 'Không thể tạo hóa đơn cho điện kế ngưng hoạt động!');
            }

            // Tính điện năng tiêu thụ
            $dienNangTieuThu = $dienKe->cs_cuoi - $dienKe->cs_dau;
            if ($dienNangTieuThu <= 0) {
                return redirect()->back()->with('error', 'Điện năng tiêu thụ phải lớn hơn 0!');
            }

            // Lấy version bậc giá mới nhất
            $latestVersion = VersionBacGia::latest('ngayapdung')->first();
            if (!$latestVersion) {
                return redirect()->back()->with('error', 'Chưa có bảng giá điện nào được thiết lập!');
            }

            // Lấy mã nhân viên từ người dùng đang đăng nhập
            $manv = null;
            if (Auth::check()) {
                $manv = Auth::user()->manv;
            } else {
                // Nếu không có người dùng đăng nhập, lấy một nhân viên mặc định
                $nhanVien = NhanVien::first();
                if (!$nhanVien) {
                    throw new \Exception('Không tìm thấy nhân viên trong hệ thống!');
                }
                $manv = $nhanVien->manv;
            }

            // Tạo mã hóa đơn mới
            do {
                $random = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT); // Đảm bảo số có 3 chữ số
                $mahd = 'HD' . $random; // Ví dụ: HD001, HD012, HD123
            } while (HoaDon::where('mahd', $mahd)->exists()); // Kiểm tra trùng lặp

            // Tạo hóa đơn mới
            $hoaDon = new HoaDon();
            $hoaDon->mahd = $mahd;
            $hoaDon->manv = $manv;
            $hoaDon->ky = date('m/Y');
            $hoaDon->tungay = date('Y-m-01');
            $hoaDon->denngay = date('Y-m-t');
            $hoaDon->chisodau = $dienKe->cs_dau;
            $hoaDon->chisocuoi = $dienKe->cs_cuoi;
            $hoaDon->ngaylaphd = now();
            $hoaDon->tinhtrang = 0;
            $hoaDon->id_version = $latestVersion->id;

            // Tính tổng tiền trước khi lưu
            $tongTien = $hoaDon->tinhTongTien();
            $hoaDon->tongthanhtien = $tongTien;
            $hoaDon->save();

            // Cập nhật chỉ số điện kế
            $dienKe->cs_dau = $dienKe->cs_cuoi;
            $dienKe->save();

            // Tạo chi tiết hóa đơn
            CTHoaDon::create([
                'mahd' => $mahd,
                'madk' => $madk,
                'dntt' => $dienNangTieuThu,
                'dongia' => $tongTien / $dienNangTieuThu
            ]);

            DB::commit();
            return redirect()->route('hoadon.index')->with('success', 'Tạo hóa đơn thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    
    public function store(Request $request)
    {
        try {
            // Xác thực dữ liệu
            $validated = $request->validate([
                'madk' => 'required|string|max:50|unique:dienke,madk',
                'makh' => 'required|string|exists:khachhang,makh',
                'mota' => 'nullable|string|max:255',
                'diachi' => 'required|string|max:255',
            ], [
                'madk.required' => 'Mã điện kế là bắt buộc',
                'madk.unique' => 'Mã điện kế đã tồn tại',
                'makh.required' => 'Mã khách hàng là bắt buộc',
                'makh.exists' => 'Mã khách hàng không tồn tại trong hệ thống',
                'diachi.required' => 'Địa chỉ lắp đặt điện kế là bắt buộc',
            ]);
            
            // Thiết lập giá trị mặc định
            $data = $request->only(['madk', 'makh', 'mota', 'diachi']);
            $data['trangthai'] = 1; // 1 = active, 0 = không hoạt động
            $data['cs_dau'] = 0;
            $data['cs_cuoi'] = 0;
            $data['ngaylap'] = now();
            
            // Kiểm tra thêm mã khách hàng
            $khachHang = KhachHang::where('makh', $request->makh)->first();
            if (!$khachHang) {
                return redirect()->back()->with('error', 'Mã khách hàng không tồn tại')->withInput();
            }
            
            // Thử tạo mới bản ghi
            $dienke = DienKe::create($data);
            
            return redirect()->route('dienke.index')->with('success', 'Thêm điện kế thành công!');
        } catch (Exception $e) {
            // Log lỗi nếu cần
            // \Log::error('Lỗi thêm điện kế: ' . $e->getMessage());
            
            // Trả về thông báo lỗi
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm điện kế: ' . $e->getMessage())->withInput();
        }
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
            'trangthai' => 'required|in:0,1', // 0 hoặc 1
        ]);
    
        // Tìm điện kế cần cập nhật
        $dienke = DienKe::findOrFail($madk);
    
        // Cập nhật trạng thái
        $dienke->update([
            'trangthai' => $request->input('trangthai'),
        ]);
    
        // Trả về thông báo thành công
        $message = $request->input('trangthai') == 1 ? 
                   'Kích hoạt điện kế thành công!' : 
                   'Vô hiệu hóa điện kế thành công!';
        
        return redirect()->back()->with('success', $message);
    }
    
    public function destroy($madk)
    {
        // Kiểm tra xem điện kế có liên quan đến hóa đơn hay không
        $hasRelatedRecords = DB::table('cthoadon')
                               ->where('madk', $madk)
                               ->exists();
        
        if ($hasRelatedRecords) {
            return redirect()->back()->with('error', 'Không thể xóa điện kế này vì đã có dữ liệu hóa đơn liên quan!');
        }
        
        $dienke = DienKe::findOrFail($madk);
        $dienke->delete();

        return redirect()->back()->with('success', 'Xóa điện kế thành công!');
    }
}

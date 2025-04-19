<?php

namespace App\Http\Controllers;

use App\Models\DienKe;
use App\Models\HoaDon;
use App\Models\CTHoaDon;
use App\Models\KhachHang;
use App\Models\BacGia;
use App\Models\NhanVien;
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
            // Kiểm tra điện kế tồn tại
            $dienke = DienKe::findOrFail($madk);
            
            // Kiểm tra chỉ số đầu và cuối
            if ($dienke->cs_dau >= $dienke->cs_cuoi) {
                return redirect()->back()->with('error', 'Không thể tạo hóa đơn: Chỉ số cuối phải lớn hơn chỉ số đầu!');
            }
            
            // Kiểm tra trạng thái hoạt động
            if ($dienke->trangthai != 1) {
                return redirect()->back()->with('error', 'Không thể tạo hóa đơn: Điện kế đang không hoạt động!');
            }
            
            // Tạo mã hóa đơn đơn giản chỉ với HD + số ngẫu nhiên
            $mahd = 'HD' . rand(1, 999);
            
            // Đảm bảo mã hóa đơn không trùng lặp
            while (HoaDon::where('mahd', $mahd)->exists()) {
                $mahd = 'HD' . rand(1, 999);
            }
            
            // Lấy nhân viên hiện tại - Xử lý trường hợp không có người dùng đăng nhập
            $manv = null;
            if (Auth::check()) {
                $user = Auth::user();
                // Kiểm tra xem user có thuộc tính manv không
                $manv = $user->manv ?? 'NV001'; // Nếu không có, dùng mã mặc định
            } else {
                // Nếu không có người dùng đăng nhập, lấy nhân viên đầu tiên trong hệ thống
                $firstNhanVien = DB::table('nhanvien')->first();
                $manv = $firstNhanVien ? $firstNhanVien->manv : 'NV001';
            }
            
            // Xác định kỳ và thời gian
            $now = Carbon::now();
            $ky = $now->format('m/Y');
            $tungay = Carbon::now()->subMonth()->startOfMonth();
            $denngay = Carbon::now()->subMonth()->endOfMonth();
            
            // Tính điện năng tiêu thụ
            $dienNangTieuThu = $dienke->cs_cuoi - $dienke->cs_dau;
            
            // Tính tổng tiền theo bậc giá
            $tongTien = 0;
            $cacBacGia = BacGia::orderBy('tusokw')->get();
            $dienNangConLai = $dienNangTieuThu;
            
            $chiTietTheoMoiBac = [];
            
            foreach ($cacBacGia as $bac) {
                if ($dienNangConLai <= 0) break;
                
                $soDien = 0;
                if ($bac->densokw === null || $bac->densokw == 99999) {
                    // Bậc không giới hạn
                    $soDien = $dienNangConLai;
                } else {
                    // Số điện trong bậc này = min(điện còn lại, số điện tối đa trong bậc)
                    $soDienToiDa = $bac->densokw - $bac->tusokw;
                    $soDien = min($dienNangConLai, $soDienToiDa);
                }
                
                $tienTheoBac = $soDien * $bac->dongia;
                $tongTien += $tienTheoBac;
                $dienNangConLai -= $soDien;
                
                // Lưu thông tin chi tiết của mỗi bậc
                $chiTietTheoMoiBac[] = [
                    'mabac' => $bac->mabac,
                    'dienNang' => $soDien,
                    'dongia' => $bac->dongia,
                    'thanhtien' => $tienTheoBac
                ];
            }
            
            // Bắt đầu transaction để đảm bảo tạo hóa đơn và chi tiết đồng bộ
            DB::beginTransaction();
            
            try {
                // Tạo hóa đơn mới
                $hoadon = HoaDon::create([
                    'mahd' => $mahd,
                    'manv' => $manv,
                    'ky' => $ky,
                    'tungay' => $tungay,
                    'denngay' => $denngay,
                    'chisodau' => $dienke->cs_dau,
                    'chisocuoi' => $dienke->cs_cuoi,
                    'tongthanhtien' => $tongTien,
                    'ngaylaphd' => now(),
                    'tinhtrang' => 0 // Chưa thanh toán
                ]);
                
                // Tạo chi tiết hóa đơn
                CTHoaDon::create([
                    'mahd' => $mahd,
                    'madk' => $dienke->madk,
                    'dntt' => $dienNangTieuThu,
                    'dongia' => $dienNangTieuThu > 0 ? $tongTien / $dienNangTieuThu : 0 // Tránh chia cho 0
                ]);
                
                // Cập nhật điện kế - di chuyển chỉ số cuối thành chỉ số đầu cho kỳ tới
                $dienke->update([
                    'cs_dau' => $dienke->cs_cuoi
                ]);
                
                DB::commit();
                
                return redirect()->route('hoadon.index')->with('success', 'Đã tạo hóa đơn thành công!');
            } catch (Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Lỗi khi tạo hóa đơn: ' . $e->getMessage());
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi tạo hóa đơn: ' . $e->getMessage());
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

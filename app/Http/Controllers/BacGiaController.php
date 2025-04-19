<?php

namespace App\Http\Controllers;

use App\Models\BacGia;
use App\Models\BacGiaHistory;
use Illuminate\Http\Request;

class BacGiaController extends Controller
{
    /**
     * Hiển thị danh sách bậc giá
     */
    public function index()
    {
        $bacgia = BacGia::all();
        return view('dashboard.giadien', compact('bacgia'));
    }
    
    /**
     * Tạo bậc giá mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenbac' => 'required|string|max:255',
            'tusokw' => 'required|numeric|min:0',
            'densokw' => 'nullable|numeric|min:0',
            'dongia' => 'required|numeric|min:0',
        ]);
        
        // Kiểm tra tusokw phải lớn hơn densokw của bậc cao nhất hiện có
        $highestBac = BacGia::orderBy('densokw', 'desc')->first();
        
        $tusokw = (int)$request->tusokw;
        $densokw = $request->densokw ? (int)$request->densokw : 99999;
        
        // Kiểm tra ràng buộc logic
        if ($highestBac && $tusokw <= $highestBac->densokw) {
            return redirect()->back()->with('error', 'Giá trị "Từ số KW" phải lớn hơn giá trị "Đến số KW" của bậc cao nhất hiện có (' . $highestBac->densokw . ')')->withInput();
        }
        
        if ($tusokw >= $densokw) {
            return redirect()->back()->with('error', 'Giá trị "Từ số KW" phải nhỏ hơn giá trị "Đến số KW"')->withInput();
        }
        
        // Tìm mã bậc cuối cùng để tạo mã mới tự động tăng
        $lastBacGia = BacGia::orderBy('mabac', 'desc')->first();
        $newMabac = $lastBacGia ? $lastBacGia->mabac + 1 : 1;
        
        // Tạo bậc giá mới
        $bacgia = BacGia::create([
            'mabac' => $newMabac,
            'tenbac' => $request->tenbac,
            'tusokw' => $tusokw,
            'densokw' => $densokw,
            'dongia' => $request->dongia,
            'ngayapdung' => now()
        ]);
        
        // Lưu lịch sử tạo mới
        BacGiaHistory::create([
            'mabac' => $bacgia->mabac,
            'tenbac' => $bacgia->tenbac,
            'tusokw' => $bacgia->tusokw,
            'densokw' => $bacgia->densokw,
            'dongia' => $bacgia->dongia,
            'ngayapdung' => $bacgia->ngayapdung,
            'ngayketthuc' => now(),
            'action' => 'create'
        ]);
        
        return redirect()->route('giadien.index')->with('success', 'Thêm bậc giá mới thành công!');
    }

    /**
     * Cập nhật bậc giá
     */
    public function update(Request $request, $mabac)
    {
        $request->validate([
            'dongia' => 'required|numeric|min:0',
            'tusokw' => 'required|numeric|min:0',
            'densokw' => 'nullable|numeric|min:0',
        ]);

        $bacgia = BacGia::findOrFail($mabac);
        
        $tusokw = (int)$request->tusokw;
        $densokw = $request->densokw ? (int)$request->densokw : 99999;
        
        // Kiểm tra logic đối với các bậc khác
        $lowerBac = BacGia::where('densokw', '<', $bacgia->tusokw)
                          ->orderBy('densokw', 'desc')
                          ->first();
                          
        $higherBac = BacGia::where('tusokw', '>', $bacgia->densokw)
                           ->orderBy('tusokw', 'asc')
                           ->first();
        
        // Kiểm tra ràng buộc đối với bậc thấp hơn
        if ($lowerBac && $tusokw <= $lowerBac->densokw) {
            return redirect()->back()->with('error', 'Giá trị "Từ số KW" phải lớn hơn giá trị "Đến số KW" của bậc thấp hơn (' . $lowerBac->densokw . ')')->withInput();
        }
        
        // Kiểm tra ràng buộc đối với bậc cao hơn
        if ($higherBac && $densokw >= $higherBac->tusokw) {
            return redirect()->back()->with('error', 'Giá trị "Đến số KW" phải nhỏ hơn giá trị "Từ số KW" của bậc cao hơn (' . $higherBac->tusokw . ')')->withInput();
        }
        
        // Kiểm tra từ phải nhỏ hơn đến
        if ($tusokw >= $densokw) {
            return redirect()->back()->with('error', 'Giá trị "Từ số KW" phải nhỏ hơn giá trị "Đến số KW"')->withInput();
        }
        
        // Lưu lịch sử trước khi cập nhật
        BacGiaHistory::create([
            'mabac' => $bacgia->mabac,
            'tenbac' => $bacgia->tenbac,
            'tusokw' => $bacgia->tusokw,
            'densokw' => $bacgia->densokw,
            'dongia' => $bacgia->dongia,
            'ngayapdung' => $bacgia->ngayapdung,
            'ngayketthuc' => now(),
            'action' => 'update'
        ]);
        
        // Cập nhật bậc giá
        $bacgia->update([
            'dongia' => $request->dongia,
            'tusokw' => $tusokw,
            'densokw' => $densokw,
            'ngayapdung' => now()
        ]);

        return redirect()->route('giadien.index')->with('success', 'Cập nhật giá điện thành công!');
    }
    
    /**
     * Xóa bậc giá
     */
    public function destroy($mabac)
    {
        $bacgia = BacGia::findOrFail($mabac);
        
        // Đảm bảo densokw không bị null khi lưu lịch sử
        $densokw = $bacgia->densokw ?? 99999;
        
        // Lưu lịch sử trước khi xóa
        BacGiaHistory::create([
            'mabac' => $bacgia->mabac,
            'tenbac' => $bacgia->tenbac,
            'tusokw' => $bacgia->tusokw,
            'densokw' => $densokw,
            'dongia' => $bacgia->dongia,
            'ngayapdung' => $bacgia->ngayapdung,
            'ngayketthuc' => now(),
            'action' => 'delete'
        ]);
        
        // Xóa bậc giá
        $bacgia->delete();
        
        return redirect()->route('giadien.index')->with('success', 'Xóa bậc giá thành công!');
    }
    
    /**
     * Hiển thị lịch sử thay đổi giá điện
     */
    public function history()
    {
        $history = BacGiaHistory::orderBy('created_at', 'desc')->get();
        return view('dashboard.giadien_history', compact('history'));
    }
    
    /**
     * Hiển thị lịch sử thay đổi của một bậc giá cụ thể
     */
    public function historyByMaBac($mabac)
    {
        $bacgia = BacGia::findOrFail($mabac);
        $history = BacGiaHistory::where('mabac', $mabac)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('dashboard.giadien_history_detail', compact('history', 'bacgia'));
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\BacGia;
use App\Models\VersionBacGia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GiaDienController extends Controller
{
    public function index()
    {
        $latestVersion = VersionBacGia::latest('ngayapdung')->first();
        $bacgia = [];
        
        if ($latestVersion) {
            $bacgia = BacGia::where('id_version', $latestVersion->id)
                           ->orderBy('tusokw')
                           ->get();
        }

        return view('dashboard.giadien', compact('bacgia', 'latestVersion'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenbac' => 'required|string|max:255',
            'tusokw' => 'required|numeric|min:0',
            'densokw' => 'required|numeric|min:0',
            'dongia' => 'required|numeric|min:0',
            'ghichu' => 'nullable|string'
        ]);

        // Kiểm tra logic khoảng số KW
        if ($request->tusokw >= $request->densokw) {
            return redirect()->back()->with('error', 'Số KW bắt đầu phải nhỏ hơn số KW kết thúc');
        }

        try {
            DB::beginTransaction();

            // Lấy version hiện tại để kiểm tra khoảng
            $latestVersion = VersionBacGia::latest('ngayapdung')->first();
            if ($latestVersion) {
                $existingRanges = BacGia::where('id_version', $latestVersion->id)
                                      ->orderBy('tusokw')
                                      ->get();
                
                // Kiểm tra chồng chéo và tính liên tục của khoảng
                foreach ($existingRanges as $range) {
                    // Kiểm tra chồng chéo
                    if (($request->tusokw >= $range->tusokw && $request->tusokw <= $range->densokw) ||
                        ($request->densokw >= $range->tusokw && $request->densokw <= $range->densokw) ||
                        ($request->tusokw <= $range->tusokw && $request->densokw >= $range->densokw)) {
                        return redirect()->back()->with('error', 'Khoảng số KW bị chồng chéo với bậc giá hiện có');
                    }
                }

                // Kiểm tra tính liên tục của khoảng
                $maxDensokw = $existingRanges->max('densokw');
                if ($maxDensokw !== null) {
                    if ($request->tusokw != $maxDensokw + 1) {
                        return redirect()->back()->with('error', 'Số KW bắt đầu phải là ' . ($maxDensokw + 1));
                    }
                } else if ($request->tusokw != 0) {
                    return redirect()->back()->with('error', 'Bậc giá đầu tiên phải bắt đầu từ 0');
                }
            } else if ($request->tusokw != 0) {
                return redirect()->back()->with('error', 'Bậc giá đầu tiên phải bắt đầu từ 0');
            }

            // Tạo version mới
            $newVersion = VersionBacGia::create([
                'ngayapdung' => Carbon::now(),
                'ghichu' => $request->ghichu
            ]);

            // Clone tất cả bậc giá từ version cũ sang version mới
            if ($latestVersion) {
                $oldBacGia = BacGia::where('id_version', $latestVersion->id)->get();
                foreach ($oldBacGia as $bg) {
                    BacGia::create([
                        'id_version' => $newVersion->id,
                        'tenbac' => $bg->tenbac,
                        'tusokw' => $bg->tusokw,
                        'densokw' => $bg->densokw,
                        'dongia' => $bg->dongia
                    ]);
                }
            }

            // Thêm bậc giá mới vào version mới
            BacGia::create([
                'id_version' => $newVersion->id,
                'tenbac' => $request->tenbac,
                'tusokw' => $request->tusokw,
                'densokw' => $request->densokw,
                'dongia' => $request->dongia
            ]);

            DB::commit();
            return redirect()->route('giadien.index')->with('success', 'Thêm bậc giá mới thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function history()
    {
        $versions = VersionBacGia::orderBy('ngayapdung', 'desc')->get();
        return view('dashboard.giadien_history', compact('versions'));
    }

    public function historyDetail($id)
    {
        $version = VersionBacGia::findOrFail($id);
        $bacGias = BacGia::where('id_version', $id)
                        ->orderBy('tusokw')
                        ->get();
        return view('dashboard.giadien_history_detail', compact('version', 'bacGias'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Tìm bậc giá cần xóa theo mabac
            $bacGia = BacGia::where('mabac', $id)->firstOrFail();
            $oldVersion = $bacGia->id_version;

            // Tạo version mới
            $newVersion = VersionBacGia::create([
                'ngayapdung' => Carbon::now(),
                'ghichu' => 'Xóa bậc giá ' . $bacGia->tenbac
            ]);

            // Clone tất cả bậc giá từ version cũ sang version mới, trừ bậc giá cần xóa
            $oldBacGia = BacGia::where('id_version', $oldVersion)
                              ->where('mabac', '!=', $id)
                              ->get();

            foreach ($oldBacGia as $bg) {
                BacGia::create([
                    'id_version' => $newVersion->id,
                    'tenbac' => $bg->tenbac,
                    'tusokw' => $bg->tusokw,
                    'densokw' => $bg->densokw,
                    'dongia' => $bg->dongia
                ]);
            }

            DB::commit();
            return redirect()->route('giadien.index')->with('success', 'Xóa bậc giá thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'tenbac' => 'required|string|max:255',
            'tusokw' => 'required|numeric|min:0',
            'densokw' => 'required|numeric|min:0',
            'dongia' => 'required|numeric|min:0',
            'ghichu' => 'nullable|string'
        ]);

        // Kiểm tra logic khoảng số KW
        if ($request->tusokw >= $request->densokw) {
            return redirect()->back()->with('error', 'Số KW bắt đầu phải nhỏ hơn số KW kết thúc');
        }

        try {
            DB::beginTransaction();

            // Tìm bậc giá cần sửa theo mabac
            $bacGia = BacGia::where('mabac', $id)->firstOrFail();
            $oldVersion = $bacGia->id_version;

            // Lấy tất cả bậc giá hiện tại để kiểm tra
            $existingRanges = BacGia::where('id_version', $oldVersion)
                                  ->where('mabac', '!=', $id)
                                  ->orderBy('tusokw')
                                  ->get();

            // Tìm bậc giá trước và sau bậc giá đang sửa
            $currentBac = BacGia::where('mabac', $id)->first();
            $prevBac = BacGia::where('id_version', $oldVersion)
                            ->where('densokw', '<', $currentBac->tusokw)
                            ->orderBy('densokw', 'desc')
                            ->first();
            $nextBac = BacGia::where('id_version', $oldVersion)
                            ->where('tusokw', '>', $currentBac->densokw)
                            ->orderBy('tusokw')
                            ->first();

            // Kiểm tra tính liên tục với bậc trước
            if ($prevBac && $request->tusokw != $prevBac->densokw + 1) {
                return redirect()->back()->with('error', 'Số KW bắt đầu phải là ' . ($prevBac->densokw + 1));
            }

            // Kiểm tra tính liên tục với bậc sau
            if ($nextBac && $request->densokw + 1 != $nextBac->tusokw) {
                return redirect()->back()->with('error', 'Số KW kết thúc phải là ' . ($nextBac->tusokw - 1));
            }

            // Kiểm tra nếu là bậc đầu tiên
            if (!$prevBac && $request->tusokw != 0) {
                return redirect()->back()->with('error', 'Bậc giá đầu tiên phải bắt đầu từ 0');
            }

            // Tạo version mới
            $newVersion = VersionBacGia::create([
                'ngayapdung' => Carbon::now(),
                'ghichu' => $request->ghichu ?? 'Cập nhật bậc giá ' . $bacGia->tenbac
            ]);

            // Clone tất cả bậc giá từ version cũ sang version mới
            $oldBacGia = BacGia::where('id_version', $oldVersion)->get();
            
            // Tạo một mảng các bậc giá mới để insert một lần
            $newBacGias = [];
            
            foreach ($oldBacGia as $bg) {
                if ($bg->mabac == $id) {
                    // Thêm bậc giá đã cập nhật vào mảng
                    $newBacGias[] = [
                        'id_version' => $newVersion->id,
                        'tenbac' => $request->tenbac,
                        'tusokw' => $request->tusokw,
                        'densokw' => $request->densokw,
                        'dongia' => $request->dongia
                    ];
                } else {
                    // Thêm các bậc giá khác vào mảng
                    $newBacGias[] = [
                        'id_version' => $newVersion->id,
                        'tenbac' => $bg->tenbac,
                        'tusokw' => $bg->tusokw,
                        'densokw' => $bg->densokw,
                        'dongia' => $bg->dongia
                    ];
                }
            }
            
            // Insert tất cả các bậc giá mới cùng một lúc
            BacGia::insert($newBacGias);

            DB::commit();
            return redirect()->route('giadien.index')->with('success', 'Cập nhật bậc giá thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 
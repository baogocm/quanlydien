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

        try {
            DB::beginTransaction();

            // Tạo version mới
            $newVersion = VersionBacGia::create([
                'ngayapdung' => Carbon::now(),
                'ghichu' => $request->ghichu
            ]);

            // Clone tất cả bậc giá từ version cũ sang version mới
            $latestVersion = VersionBacGia::where('id', '<>', $newVersion->id)
                                        ->latest('ngayapdung')
                                        ->first();

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

        try {
            DB::beginTransaction();

            // Tìm bậc giá cần sửa theo mabac
            $bacGia = BacGia::where('mabac', $id)->firstOrFail();
            $oldVersion = $bacGia->id_version;

            // Tạo version mới
            $newVersion = VersionBacGia::create([
                'ngayapdung' => Carbon::now(),
                'ghichu' => $request->ghichu ?? 'Cập nhật bậc giá ' . $bacGia->tenbac
            ]);

            // Clone tất cả bậc giá từ version cũ sang version mới
            $oldBacGia = BacGia::where('id_version', $oldVersion)->get();
            foreach ($oldBacGia as $bg) {
                if ($bg->mabac == $id) {
                    // Tạo bậc giá mới với thông tin đã cập nhật
                    BacGia::create([
                        'id_version' => $newVersion->id,
                        'mabac' => $bg->mabac,
                        'tenbac' => $request->tenbac,
                        'tusokw' => $request->tusokw,
                        'densokw' => $request->densokw,
                        'dongia' => $request->dongia
                    ]);
                } else {
                    // Clone các bậc giá khác
                    BacGia::create([
                        'id_version' => $newVersion->id,
                        'mabac' => $bg->mabac,
                        'tenbac' => $bg->tenbac,
                        'tusokw' => $bg->tusokw,
                        'densokw' => $bg->densokw,
                        'dongia' => $bg->dongia
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('giadien.index')->with('success', 'Cập nhật bậc giá thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\BacGia;
use Illuminate\Http\Request;

class BacGiaController extends Controller
{
    public function update(Request $request, $mabac)
    {
        $request->validate([
            'dongia' => 'required|numeric|min:0',
            'tusokw' => 'required|numeric|min:0',
            'densokw' => 'nullable|numeric|min:0',
        ]);

        $bacgia = BacGia::findOrFail($mabac);
        
        $bacgia->update([
            'dongia' => $request->dongia,
            'tusokw' => $request->tusokw,
            'densokw' => $request->densokw,
            'ngayapdung' => now()
        ]);

        return redirect()->route('giadien.index')->with('success', 'Cập nhật giá điện thành công!');
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use Illuminate\Http\Request;

class HoaDonController extends Controller
{
    public function updateStatus($mahd)
    {
        try {
            $hoadon = HoaDon::findOrFail($mahd);
            $hoadon->update(['tinhtrang' => 1]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
} 
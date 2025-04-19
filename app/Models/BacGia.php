<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacGia extends Model
{
    use HasFactory;
    
    /**
     * Tên bảng trong cơ sở dữ liệu
     */
    protected $table = 'bacgia';
    
    /**
     * Khóa chính
     */
    protected $primaryKey = 'mabac';
    
    /**
     * Vô hiệu hóa timestamps (created_at, updated_at)
     */
    public $timestamps = false;
    
    /**
     * Các trường có thể gán giá trị
     */
    protected $fillable = [
        'mabac',    // ID bậc giá (7, 8, 9, 10, 11...)
        'tenbac',   // Tên bậc (Bậc 1, Bậc 2, Bậc 3...)
        'tusokw',   // Giới hạn dưới KW (0, 51, 101, 201, 301...)
        'densokw',  // Giới hạn trên KW (50, 100, 200, 300, 99999...)
        'dongia',   // Đơn giá (1500.00, 1800.00, 2000.00...)
        'ngayapdung' // Ngày áp dụng (2025-01-01 00:00:00)
    ];
    
    /**
     * Relationship với bảng lịch sử giá điện
     */
    public function history()
    {
        return $this->hasMany(BacGiaHistory::class, 'mabac', 'mabac');
    }
    
    /**
     * Tính tiền điện dựa trên số KW tiêu thụ
     */
    public static function tinhTienDien($soKW)
    {
        $tongTien = 0;
        $bacGia = self::orderBy('tusokw')->get();
        
        foreach ($bacGia as $bac) {
            // Nếu số KW tiêu thụ nhỏ hơn giới hạn dưới của bậc này, bỏ qua
            if ($soKW < $bac->tusokw) continue;
            
            // Tính số KW trong bậc này
            $kwTrongBac = min($soKW, $bac->densokw) - $bac->tusokw;
            
            if ($kwTrongBac > 0) {
                $tongTien += $kwTrongBac * $bac->dongia;
            }
            
            // Nếu số KW tiêu thụ nhỏ hơn hoặc bằng giới hạn trên của bậc này, dừng lại
            if ($soKW <= $bac->densokw) break;
        }
        
        return $tongTien;
    }
    
    /**
     * Lấy bậc giá theo số KW
     */
    public static function getBacGiaByKW($soKW)
    {
        return self::where('tusokw', '<=', $soKW)
                  ->where(function($query) use ($soKW) {
                      $query->where('densokw', '>=', $soKW)
                            ->orWhereNull('densokw');
                  })
                  ->first();
    }
} 
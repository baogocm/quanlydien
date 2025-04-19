<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacGiaHistory extends Model
{
    use HasFactory;
    
    protected $table = 'bacgia_history';
    protected $fillable = [
        'mabac', 
        'tenbac', 
        'tusokw', 
        'densokw', 
        'dongia', 
        'ngayapdung',
        'ngayketthuc',
        'action'
    ];
    
    /**
     * Lấy dữ liệu lịch sử của một bậc giá cụ thể
     */
    public static function getHistoryByMaBac($mabac)
    {
        return self::where('mabac', $mabac)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * Lấy toàn bộ lịch sử thay đổi giá
     */
    public static function getAllHistory()
    {
        return self::orderBy('created_at', 'desc')->get();
    }
    
    /**
     * Relationship với bảng BacGia
     */
    public function bacGia()
    {
        return $this->belongsTo(BacGia::class, 'mabac', 'mabac');
    }
} 
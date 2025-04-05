<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DienKe extends Model
{
    use HasFactory;
    protected $table = 'dienke';
    protected $primaryKey = 'madk';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['madk', 'makh', 'ngaylap', 'mota', 'trangthai', 'cs_dau', 'cs_cuoi'];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'makh', 'makh');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    use HasFactory;
    protected $table = 'hoadon';
    protected $primaryKey = 'mahd';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['mahd', 'manv', 'ky', 'tungay', 'denngay', 'chisodau', 'chisocuoi', 'tongthanhtien', 'ngaylaphd', 'tinhtrang'];

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'manv', 'manv');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuXem extends Model
{
    use HasFactory;
    protected $table = 'lichsuxem';
    protected $primaryKey = 'maxem';
    public $timestamps = false;
    protected $fillable = ['maxem', 'thoigianxem', 'manv'];

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'manv', 'manv');
    }
}

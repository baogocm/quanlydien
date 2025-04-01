<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    use HasFactory;
    protected $table = 'nhanvien';
    protected $primaryKey = 'manv';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['manv', 'ngaysinh', 'chucvu', 'tk', 'mk', 'phai', 'luong', 'sdt'];
}

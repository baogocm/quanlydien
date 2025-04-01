<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;
    protected $table = 'khachhang';
    protected $primaryKey = 'makh';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['makh', 'tenkh', 'diachi', 'dt', 'cmnd'];

    public function dienKes()
    {
        return $this->hasMany(DienKe::class, 'makh', 'makh');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacGia extends Model
{
    use HasFactory;
    protected $table = 'bacgia';
    protected $primaryKey = 'mabac';
    public $timestamps = false;
    protected $fillable = ['mabac', 'tenbac', 'tusokw', 'densokw', 'dongia', 'ngayapdung'];
}

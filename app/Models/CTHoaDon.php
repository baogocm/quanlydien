<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CTHoaDon extends Model
{
    use HasFactory;
    protected $table = 'cthoadon';
    public $timestamps = false;
    protected $fillable = ['mahd', 'madk', 'dntt', 'dongia'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionBacGia extends Model
{
    use HasFactory;
    
    protected $table = 'version_bacgia';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'ngayapdung',
        'ghichu'
    ];

    public function bacGias()
    {
        return $this->hasMany(BacGia::class, 'id_version', 'id');
    }

    public static function getVersionByDate($date)
    {
        return self::where('ngayapdung', '<=', $date)
            ->orderBy('ngayapdung', 'desc')
            ->first();
    }
} 
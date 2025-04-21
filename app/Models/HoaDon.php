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
    protected $fillable = [
        'mahd', 
        'manv', 
        'ky', 
        'tungay', 
        'denngay', 
        'chisodau', 
        'chisocuoi', 
        'tongthanhtien', 
        'ngaylaphd', 
        'tinhtrang',
        'id_version'
    ];

    public function chiTietHoaDon()
    {
        return $this->hasOne(CTHoaDon::class, 'mahd', 'mahd');
    }

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'manv', 'manv');
    }

    public function versionBacGia()
    {
        return $this->belongsTo(VersionBacGia::class, 'id_version', 'id');
    }

    public function tinhTongTien()
    {
        $tongDienNangTieuThu = $this->chisocuoi - $this->chisodau;
        $bacGia = BacGia::where('id_version', $this->id_version)
            ->orderBy('tusokw')
            ->get()
            ->unique(function ($item) {
                return $item->tusokw . '-' . $item->densokw . '-' . $item->dongia;
            });
            
        $tongTien = 0;
        $dienNangConLai = $tongDienNangTieuThu;

        foreach ($bacGia as $bac) {
            if ($dienNangConLai <= 0) break;

            $soDien = 0;
            if ($bac->densokw === null || $bac->densokw == 99999) {
                $soDien = $dienNangConLai;
            } else {
                $soDien = min($dienNangConLai, $bac->densokw - $bac->tusokw);
            }

            $tongTien += $soDien * $bac->dongia;
            $dienNangConLai -= $soDien;
        }

        return $tongTien;
    }
}

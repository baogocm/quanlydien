<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VersionBacGia;
use Carbon\Carbon;

class VersionBacGiaSeeder extends Seeder
{
    public function run()
    {
        // Xóa dữ liệu cũ nếu có
        VersionBacGia::truncate();

        // Tạo các version bậc giá mẫu
        $versions = [
            [
                'id' => 1,
                'ngayapdung' => '2023-01-01 00:00:00',
                'ghichu' => 'Bảng giá điện năm 2023'
            ],
            [
                'id' => 2,
                'ngayapdung' => '2024-01-01 00:00:00',
                'ghichu' => 'Bảng giá điện năm 2024'
            ]
        ];

        foreach ($versions as $version) {
            VersionBacGia::create($version);
        }
    }
} 
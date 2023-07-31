<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolYearSeeder extends Seeder
{
    public function run()
    {
        $schoolYears = [
            [
                'name' => '2023-2024', // Ganti dengan nama tahun ajaran yang diinginkan
                'headmaster_name' => 'Arifudin', // Ganti dengan nama kepala sekolah yang diinginkan
                'is_active' => true,
            ],
        ];

        // Masukkan data ke dalam tabel school_years
        DB::table('school_years')->insert($schoolYears);
    }
}

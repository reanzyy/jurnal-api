<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run()
    {
        $companies = [
            [
                'name' => 'Arka Tech', // Ganti dengan nama perusahaan yang diinginkan
                'address' => 'Bandung',
                'director' => 'Khoirul Amri', // Ganti dengan nama direktur perusahaan yang diinginkan
            ],
        ];

        // Masukkan data ke dalam tabel companies
        DB::table('companies')->insert($companies);
    }
}


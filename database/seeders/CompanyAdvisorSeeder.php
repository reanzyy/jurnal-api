<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyAdvisorSeeder extends Seeder
{
    public function run()
    {
        $companyAdvisors = [
            [
                'company_id' => 1, // Ganti dengan id perusahaan yang ada di tabel companies
                'identity' => '87654321', // Ganti dengan identitas advisor yang unik (sebagai username)
                'name' => 'Khoirul Amri',
                'phone' => '0897654321',
                'gender' => 'male', // Pilihan: 'male' atau 'female'
            ],
        ];

        // Masukkan data ke dalam tabel company_advisors
        DB::table('company_advisors')->insert($companyAdvisors);
    }
}


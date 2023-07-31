<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolAdvisorSeeder extends Seeder
{
    public function run()
    {
        $schoolAdvisors = [
            [
                'identity' => '12345678', // Ganti dengan identitas advisor yang unik (sebagai username)
                'name' => 'Dudung Zulkipli',
                'phone' => '08123456789',
                'address' => 'Kuningan',
                'gender' => 'male', // Pilihan: 'male' atau 'female'
                'is_active' => true,
            ],
        ];

        // Masukkan data ke dalam tabel school_advisors
        DB::table('school_advisors')->insert($schoolAdvisors);
    }
}


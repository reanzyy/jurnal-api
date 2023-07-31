<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternshipSeeder extends Seeder
{
    public function run()
    {
        $internships = [
            [
                'user_id' => 1,
                'school_year_id' => 1, // Ganti dengan id tahun ajaran yang ada di tabel school_years
                'student_id' => 1, // Ganti dengan id siswa yang ada di tabel students
                'company_id' => 1, // Ganti dengan id perusahaan yang ada di tabel companies
                'school_advisor_id' => 1, // Ganti dengan id advisor sekolah yang ada di tabel school_advisors
                'company_advisor_id' => 1, // Ganti dengan id advisor perusahaan yang ada di tabel company_advisors (kosongkan jika tidak ada)
                'working_day' => 'mon-fri', // Pilihan: 'mon-fri' atau 'mon-sat'
            ],
        ];

        // Masukkan data ke dalam tabel internships
        DB::table('internships')->insert($internships);
    }
}


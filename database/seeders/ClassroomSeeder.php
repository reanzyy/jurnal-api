<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    public function run()
    {
        $classrooms = [
            [
                'school_year_id' => 1, // Ganti dengan id tahun ajaran yang ada di tabel school_years
                'name' => 'XII',
                'vocational_program' => 'Rekayasa Perangkat Lunak',
                'vocational_competency' => 'Teknik Informasi dan Komunikasi',
            ],
            [
                'school_year_id' => 1, // Ganti dengan id tahun ajaran yang ada di tabel school_years
                'name' => 'XII',
                'vocational_program' => 'Teknik Komunikasi dan Jaringan',
                'vocational_competency' => 'Teknik Informasi dan Komunikasi',
            ],
        ];

        // Masukkan data ke dalam tabel classrooms
        DB::table('classrooms')->insert($classrooms);
    }
}

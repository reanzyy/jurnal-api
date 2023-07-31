<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $students = [
            [
                'user_id' => 1,
                'school_year_id' => 1,
                'classroom_id' => 1,
                'identity' => '12127575',
                'name' => 'Mohamad Haikal Dwiki Akbar',
                'phone' => '0812345678910',
                'birth_date' => '2006-02-23',
                'birth_place' => 'Cirebon',
                'religion' => 'Islam',
                'gender' => 'Male',
                'address' => 'Cirebon',
                'blood_type' => 'O',
            ],
        ];

        // Masukkan data ke dalam tabel students
        DB::table('students')->insert($students);
    }
}

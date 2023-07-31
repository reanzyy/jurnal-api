<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            SchoolYearSeeder::class,
            ClassroomSeeder::class,
            CompanySeeder::class,
            StudentSeeder::class,
            SchoolAdvisorSeeder::class,
            CompanyAdvisorSeeder::class,
            InternshipSeeder::class,
        ]);
    }
}

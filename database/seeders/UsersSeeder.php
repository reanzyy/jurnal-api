<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'username' => '12127575',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
            [
                'username' => '12127578',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
            [
                'username' => '12345678',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
            [
                'username' => '87654321',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
        ]);
    }
}

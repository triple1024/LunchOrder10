<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/02/09 14:51:37',
            ],
            [
                'name' => 'user1',
                'email' => 'user1@user.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/02/09 14:51:37',
            ],
            [
                'name' => 'user2',
                'email' => 'user2@user.com',
                'password' => Hash::make('password123'),
                'created_at' => '2024/02/09 14:51:37',
            ],

        ]);
    }
}

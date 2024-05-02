<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('food')->insert([
            [
                'owner_id' => 1,
                'name' => 'ほっけ',
                'secondary_category_id' => 2,
                'is_selling' => 1,
            ],
        ]);
    }
}

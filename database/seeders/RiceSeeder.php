<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("rice")->insert([
            [
                'name'  => '並',
                'weight' => 200,
                'is_selling' => 1,
            ],
            [
                'name'  => '少なめ',
                'weight' => 150,
                'is_selling' => 1,
            ],
            [
                'name'  => '並',
                'weight' => 120,
                'is_selling' => 1,
            ],
            [
                'name'  => 'なし',
                'weight' => 0,
                'is_selling' => 1,
            ],

        ]);
    }
}

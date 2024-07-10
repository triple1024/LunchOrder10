<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('primary_categories')->insert([
            [
                'name' => '弁当',
                'sort_order' => '1',
            ],
            [
                'name' => 'パン',
                'sort_order' => '2',
            ],
        ]);

        DB::table('secondary_categories')->insert([
            [
                'name' => '肉系',
                'sort_order' => '1',
                'primary_category_id' => '1',
            ],
            [
                'name' => '魚介系',
                'sort_order' => '2',
                'primary_category_id' => '1',
            ],
            [
                'name' => '惣菜パン',
                'sort_order' => '3',
                'primary_category_id' => '2',
            ],
            [
                'name' => '菓子パン',
                'sort_order' => '4',
                'primary_category_id' => '2',
            ],
        ]);
    }
}
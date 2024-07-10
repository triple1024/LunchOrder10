<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_stocks')->insert([
            [
                'food_id' => 1,
                'type' =>  1,
                'quantity' => 8,
            ],
            [
                'food_id' => 2,
                'type' =>  1,
                'quantity' => 4,
            ],
            [
                'food_id' => 3,
                'type' =>  1,
                'quantity' => 9,
            ],
            [
                'food_id' => 4,
                'type' =>  1,
                'quantity' => 6,
            ],
            [
                'food_id' => 5,
                'type' =>  1,
                'quantity' => 7,
            ],
            [
                'food_id' => 6,
                'type' =>  1,
                'quantity' => 8,
            ],
            [
                'food_id' => 7,
                'type' =>  1,
                'quantity' => 5,
            ],
            [
                'food_id' => 8,
                'type' =>  1,
                'quantity' => 8,
            ],
            [
                'food_id' => 9,
                'type' =>  1,
                'quantity' => 10,
            ],
            [
                'food_id' => 10,
                'type' =>  1,
                'quantity' => 8,
            ],
            [
                'food_id' => 11,
                'type' =>  1,
                'quantity' => 6,
            ],
            [
                'food_id' => 12,
                'type' =>  1,
                'quantity' => 7,
            ],
            [
                'food_id' => 13,
                'type' =>  1,
                'quantity' => 6,
            ],
            [
                'food_id' => 14,
                'type' =>  1,
                'quantity' => 5,
            ],
            [
                'food_id' => 15,
                'type' =>  1,
                'quantity' => 9,
            ],
            [
                'food_id' => 16,
                'type' =>  1,
                'quantity' => 4,
            ],
            [
                'food_id' => 17,
                'type' =>  1,
                'quantity' => 6,
            ],


        ]);
    }
}

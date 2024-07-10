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
                'can_choose_bread' => 0,
                'image1' => 1,
            ],
            [
                'owner_id' => 1,
                'name' => '焼売',
                'secondary_category_id' => 1,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 2,
            ],
            [
                'owner_id' => 1,
                'name' => 'チョココロネ',
                'secondary_category_id' => 4,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 3,
            ],
            [
                'owner_id' => 1,
                'name' => 'クロワッサン',
                'secondary_category_id' => 3,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 4,
            ],
            [
                'owner_id' => 1,
                'name' => 'トムヤムクン',
                'secondary_category_id' => 2,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 5,
            ],
            [
                'owner_id' => 1,
                'name' => 'シナモンロール',
                'secondary_category_id' => 4,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 6,
            ],
            [
                'owner_id' => 1,
                'name' => 'ささみ',
                'secondary_category_id' => 1,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 7,
            ],
            [
                'owner_id' => 1,
                'name' => 'グリーンカレー',
                'secondary_category_id' => 1,
                'is_selling' => 1,
                'can_choose_bread' => 1,
                'image1' => 8,
            ],
            [
                'owner_id' => 1,
                'name' => 'アジフライ',
                'secondary_category_id' => 2,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 9,
            ],
            [
                'owner_id' => 1,
                'name' => 'ハンバーガー',
                'secondary_category_id' => 3,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 10,
            ],
            [
                'owner_id' => 1,
                'name' => '焼豚',
                'secondary_category_id' => 1,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 11,
            ],
            [
                'owner_id' => 1,
                'name' => 'ビーフシチュー',
                'secondary_category_id' => 1,
                'is_selling' => 1,
                'can_choose_bread' => 1,
                'image1' => 12,
            ],
            [
                'owner_id' => 1,
                'name' => 'ホットドッグ',
                'secondary_category_id' => 3,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 13,
            ],
            [
                'owner_id' => 1,
                'name' => 'さんま',
                'secondary_category_id' => 2,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 14,
            ],
            [
                'owner_id' => 1,
                'name' => 'メロンパン',
                'secondary_category_id' => 4,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 15,
            ],
            [
                'owner_id' => 1,
                'name' => 'エビフライ',
                'secondary_category_id' => 2,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 16,
            ],
            [
                'owner_id' => 1,
                'name' => '参鶏湯',
                'secondary_category_id' => 1,
                'is_selling' => 1,
                'can_choose_bread' => 0,
                'image1' => 17,
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("images")->insert([
            [
                'owner_id' => '1',
                'filename' => 'sample1.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample2.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample3.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample4.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample5.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample6.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample7.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample8.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample9.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample10.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample11.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample12.jpg',
                'title' => '',
            ],
            [
                'owner_id' => '1',
                'filename' => 'sample13.jpg',
                'title' => '',
            ],
        ]);

    }
}
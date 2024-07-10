<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Food;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            OwnerSeeder::class,
            ImageSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            FoodSeeder::class,
            StockSeeder::class,
            RiceSeeder::class,
        ]);
    }
}

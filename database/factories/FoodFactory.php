<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> $this->faker->name,
            'is_selling'=> $this->faker->numberBetween(0,1),
            'sort_order'=> $this->faker->randomNumber,
            'secondary_category_id'=> $this->faker->numberBetween(1,4),
            'image1'=> $this->faker->numberBetween(1,13),
        ];
    }
}

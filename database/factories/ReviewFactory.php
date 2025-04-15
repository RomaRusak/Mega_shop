<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id'  => Product::get()->random()->id, 
            'user_id'     => User::get()->random()->id, 
            'review_text' => $this->faker->paragraph(), 
            'rating'      => rand(1, 10),
        ];
    }
}

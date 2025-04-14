<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "discount_percent" => 5,
            "discount_start"   => now()->format('Y-m-d'),
            "discount_end"     => now()->addDay($this->faker->randomDigitNotNull())->format('Y-m-d'),
        ];
    }
}

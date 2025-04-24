<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            "Men's Outerwear", 
            "Men's Bottoms",
            "Men's Footwear",
            "Women's Outerwear",
            "Women's Bottoms",
            "Women's Footwear",
        ]);
        $slug = strtolower(str_replace(' ', '_', $name));
        $slug = preg_replace('/[^a-zA-Z_]/', '', $slug);

        return [
            'name' => $name,
            'slug' => $slug,
        ];
    }
}

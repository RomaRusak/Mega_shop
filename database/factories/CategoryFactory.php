<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Helpers\SlugHelper;

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
        
        $slug = SlugHelper::createSlug($name, '/[^a-zA-Z_]/');

        return [
            'name' => $name,
            'slug' => $slug,
        ];
    }
}

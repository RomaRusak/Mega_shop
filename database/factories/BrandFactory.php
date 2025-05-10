<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Helpers\SlugHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->company();
        $slug = SlugHelper::createSlug($name, '/[^a-zA-Z_-]/');

        return [
            'name' => $name,
            'slug' => $slug,
        ];
    }
}

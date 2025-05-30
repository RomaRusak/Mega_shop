<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Http\Helpers\SlugHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $name = $this->faker->unique()->sentence(3);
        $slug = SlugHelper::createSlug($name, '/[^a-zA-Z0-9-_]/');

        return [
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->faker->paragraph(), 
            'brand_id'    => Brand::get()->random()->id, 
            'category_id' => Category::get()->random()->id, 
            'rating'      => null,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $product->update(['slug' => $product->slug . '-' . $product->id]);
        });
    }
}

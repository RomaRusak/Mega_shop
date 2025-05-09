<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Gallery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'product_id' => Product::get()->random()->id,  
            'gallery_id' => Gallery::get()->random()->id, 
            'size'       => $this->faker->randomElement(['s_size', 'm_size', 'l_size', 'xl_size']), 
            'color'      => $this->faker->randomElement(['red', 'green', 'blue']), 
            'quantity'   => $this->faker->randomNumber(2, true), 
            'price'      => $this->faker->randomFloat(2, 10, 300),
        ];
    }
}

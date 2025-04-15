<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductVariant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'cart_contains' => $this->generateCartContainsJSON(),
        ];
    }

    private function generateCartContainsJSON()
    {
        $cartContains = [];

        $randmoProdVarCounter  = rand(0,2);
        $randmoProdVariants    = ProductVariant::all()->shuffle()->take($randmoProdVarCounter)->toArray();

        for ($i = 0; $i < count($randmoProdVariants); $i++) {
            $cartContains[] = [
                ['product_varitant_id' => $randmoProdVariants[$i]['id']],
                ['quantity'            => rand(1,2)],
            ];
        };

        return json_encode($cartContains);
    }
}

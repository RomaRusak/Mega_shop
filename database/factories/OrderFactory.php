<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\ProductVariant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomUser          = User::get()->random();
        $randomUserId        = $randomUser->id;
        $randomUserAddressId = $randomUser->addresses->random()->id;

        return [
            'address_id'     => $randomUserAddressId, 
            'user_id'        => $randomUserId, 
            'order_contains' => $this->generateOrderContainsJSON(), 
            'status'         => $this->faker->randomElement(['processing', 'in Transit', 'delivered']),
        ];
    }

    private function generateOrderContainsJSON()
    {
        $orderContains = [];

        $randmoProdVarCounter  = rand(1,2);
        $randmoProdVariants    = ProductVariant::all()->shuffle()->take($randmoProdVarCounter)->toArray();

        for ($i = 0; $i < count($randmoProdVariants); $i++) {
            $orderContains[] = [
                ['product_varitant_id' => $randmoProdVariants[$i]['id']],
                ['quantity'            => rand(1,2)],
            ];
        };

        return json_encode($orderContains);
    }
}

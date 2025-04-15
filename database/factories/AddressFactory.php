<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city'             => $this->faker->city(),
            'street'           => $this->faker->streetName(),
            'house_number'     => rand(1,99), 
            'corp_number'      => rand(1,20), 
            'apartment_number' => rand(1, 99),
        ];
    }
}

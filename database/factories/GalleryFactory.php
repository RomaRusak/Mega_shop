<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    private function generateImagePathsJSON(): string
    {

        $gallery = [];
        
        $imageText = $this->faker->word();

        for ($i = 0; $i < $this->faker->randomDigitNotNull(); $i++) {
            $gallery[] = $this->faker->image('public/images', 640, 480, $imageText . ' ' . $this->faker->word());
        };
        
        return json_encode($gallery);
    }

    public function definition(): array
    {
        return [
            'image_paths' => $this->generateImagePathsJSON(),
        ];
    }
}

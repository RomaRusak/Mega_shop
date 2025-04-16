<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Helpers\ImageHepler;

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

        for ($i = 0; $i < rand(1,3); $i++) {
            $imagePath = ImageHepler::createImage(public_path('images'), 640, 480, $imageText . ' ' . $this->faker->word());
            $gallery[] = $imagePath;
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

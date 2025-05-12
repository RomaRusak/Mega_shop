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

        for ($i = 0; $i < rand(1,4); $i++) {
            $imageData = ['image' => null, 'isMainImage' => false];
            $imagePath = base_path('mega_shop_front/src/assets');
            $imageData['image'] = basename(ImageHepler::createImage($imagePath, 640, 480, $imageText . ' ' . $this->faker->word()));
            $gallery[] = $imageData;
        };

        $gallery[0]['isMainImage'] = true;
        
        return json_encode($gallery);
    }

    
    public function definition(): array
    {
        return [
            'image_paths' => $this->generateImagePathsJSON(),
        ];
    }
}

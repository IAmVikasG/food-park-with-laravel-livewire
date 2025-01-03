<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all products
        Product::all()->each(function ($product) use ($faker) {
            // Generate 3-5 images for each product
            $numberOfImages = rand(3, 5);

            for ($i = 0; $i < $numberOfImages; $i++) {
                // Create a temporary file with faker image
                $tempImage = $faker->image(storage_path('app/temp'), 640, 480);

                if ($tempImage) {
                    // Add media with custom properties
                    $product->addMedia($tempImage)
                        ->withCustomProperties([
                            'is_primary' => ($i === 0), // First image is primary
                            'sort_order' => $i + 1,
                            'alt_text' => $faker->sentence(3),
                            'title' => $faker->sentence(2)
                        ])
                        ->toMediaCollection('product_images');

                    // Delete the temporary file
                    @unlink($tempImage);
                }
            }
        });
    }
}

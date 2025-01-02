<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $pizzaNames = [
            'Margherita',
            'Pepperoni',
            'Hawaiian',
            'BBQ Chicken',
            'Vegetarian',
            'Supreme',
            'Mushroom',
            'Four Cheese'
        ];

        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->randomElement($pizzaNames),
            'description' => $this->faker->paragraph(),
            'base_price' => $this->faker->randomFloat(2, 8, 25),
            'is_available' => $this->faker->boolean(90),
            'preparation_time' => $this->faker->numberBetween(15, 45),
        ];
    }

    /**
     * Configure the factory to add an image to each Slider.
     */
    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->addMediaFromUrl('https://picsum.photos/id/10/200/300')
            ->toMediaCollection('product_images');
        });
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(['product', 'blog']),
            'parent_id' => function () {
                // 30% chance of having a parent category
                return $this->faker->boolean(30)
                    ? Category::inRandomOrder()->first()?->id
                    : null;
            },
            'meta_title' => $this->faker->sentence(),
            'meta_description' => $this->faker->text(160),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }

    /**
     * Configure the factory to add an image to each Slider.
     */
    public function configure()
    {
        return $this->afterCreating(function (Category $category) {
            $category->addMediaFromUrl('https://picsum.photos/id/1/200/300')
            ->toMediaCollection('category_images');
        });
    }

    /**
     * Configure the factory to generate product categories.
     */
    public function product(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'product',
            ];
        });
    }

    /**
     * Configure the factory to generate blog categories.
     */
    public function blog(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'blog',
            ];
        });
    }
}

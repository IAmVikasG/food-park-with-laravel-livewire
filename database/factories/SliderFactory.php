<?php

namespace Database\Factories;

use App\Models\Slider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'offer' => $this->faker->sentence(3),
            'title' => $this->faker->sentence(5),
            'subtitle' => $this->faker->sentence(7),
            'description' => $this->faker->paragraph(),
            'btn_link' => $this->faker->url(),
            'order' => $this->faker->numberBetween(1, 100),
            'is_active' => $this->faker->boolean(80),
            'created_by' => User::factory(),
        ];
    }

    /**
     * Configure the factory to add an image to each Slider.
     */
    public function configure()
    {
        return $this->afterCreating(function (Slider $slider) {
            $slider->addMediaFromUrl('https://picsum.photos/id/10/200/300')
                ->toMediaCollection('slider_images');
        });
    }
}

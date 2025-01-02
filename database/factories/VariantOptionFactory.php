<?php

namespace Database\Factories;

use App\Models\VariantType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VariantOption>
 */
class VariantOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $options = [
            'Size' => ['Small', 'Medium', 'Large', 'Extra Large'],
            'Crust' => ['Thin', 'Thick', 'Stuffed', 'Gluten-Free'],
            'Extra Cheese' => ['Yes', 'No'],
            'Toppings' => ['Mushrooms', 'Olives', 'Extra Pepperoni', 'Bell Peppers']
        ];
        
        $type = VariantType::factory()->create();
        $optionsForType = $options[$type->name] ?? ['Option 1', 'Option 2'];

        return [
            'variant_type_id' => $type,
            'name' => $this->faker->randomElement($optionsForType),
        ];
    }
}

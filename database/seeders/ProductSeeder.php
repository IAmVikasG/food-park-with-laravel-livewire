<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pizzaCategory = Category::where('name', 'Pizzas')->first();

        $pizzas = [
            [
                'name' => 'Margherita',
                'description' => 'Classic pizza with tomato sauce, mozzarella, and fresh basil',
                'base_price' => 12.99,
                'preparation_time' => 20,
            ],
            [
                'name' => 'Pepperoni',
                'description' => 'Traditional pizza topped with spicy pepperoni and mozzarella',
                'base_price' => 14.99,
                'preparation_time' => 25,
            ],
            [
                'name' => 'Supreme',
                'description' => 'Loaded with pepperoni, sausage, bell peppers, onions, and olives',
                'base_price' => 16.99,
                'preparation_time' => 30,
            ],
        ];

        foreach ($pizzas as $pizza) {
            Product::create(array_merge($pizza, [
                'category_id' => $pizzaCategory->id,
                'is_available' => true,
            ]));
        }

        // Create some random products for testing
        // Product::factory(10)->create();
    }
}

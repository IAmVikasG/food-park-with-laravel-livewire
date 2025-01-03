<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FoodOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {


        // Products
        $products = [
            [
                'category_id' => 1, // Pizza
                'name' => 'Margherita Pizza',
                'slug' => 'margherita-pizza',
                'description' => 'Classic Italian pizza with fresh basil, tomatoes, and mozzarella cheese.',
                'price' => 12.99,
                'sale_price' => 10.99,
                'stock' => 50,
                'is_active' => true,
                'prep_time' => 20,
                'meta_title' => 'Fresh Margherita Pizza | Best Italian Pizza',
                'meta_description' => 'Order our delicious Margherita Pizza made with fresh ingredients and authentic Italian recipe.',
                'featured' => true,
                'additional_charges' => json_encode([
                    'delivery_fee' => 2.50,
                    'packing_charge' => 1.00
                ]),
                'tax_rules' => json_encode([
                    'tax_percentage' => 8,
                    'discount_percentage' => 15
                ])
            ],
            [
                'category_id' => 2, // Burgers
                'name' => 'Classic Cheeseburger',
                'slug' => 'classic-cheeseburger',
                'description' => 'Juicy beef patty with melted cheddar cheese, fresh lettuce, tomatoes, and our special sauce.',
                'price' => 9.99,
                'sale_price' => null,
                'stock' => 30,
                'is_active' => true,
                'prep_time' => 15,
                'meta_title' => 'Classic Cheeseburger | Gourmet Burgers',
                'meta_description' => 'Try our mouthwatering Classic Cheeseburger made with 100% pure beef and fresh ingredients.',
                'featured' => true,
                'additional_charges' => json_encode([
                    'delivery_fee' => 2.50,
                    'packing_charge' => 1.00
                ]),
                'tax_rules' => json_encode([
                    'tax_percentage' => 8,
                    'discount_percentage' => 0
                ])
            ]
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }

        // Product Variants
        $variants = [
            [
                'product_id' => 1, // For Pizza
                'name' => 'Size',
                'type' => 'single_select',
                'required' => true,
                'max_choices' => 1
            ],
            [
                'product_id' => 1,
                'name' => 'Crust',
                'type' => 'single_select',
                'required' => true,
                'max_choices' => 1
            ],
            [
                'product_id' => 2, // For Burger
                'name' => 'Patty Cook Level',
                'type' => 'single_select',
                'required' => true,
                'max_choices' => 1
            ]
        ];

        foreach ($variants as $variant) {
            DB::table('product_variants')->insert($variant);
        }

        // Variant Options
        $variantOptions = [
            // Pizza Sizes
            [
                'product_variant_id' => 1,
                'name' => 'Small (8")',
                'price_adjustment' => 0.00,
                'stock' => 20,
                'is_active' => true
            ],
            [
                'product_variant_id' => 1,
                'name' => 'Medium (12")',
                'price_adjustment' => 4.00,
                'stock' => 20,
                'is_active' => true
            ],
            [
                'product_variant_id' => 1,
                'name' => 'Large (16")',
                'price_adjustment' => 8.00,
                'stock' => 10,
                'is_active' => true
            ],
            // Pizza Crusts
            [
                'product_variant_id' => 2,
                'name' => 'Thin Crust',
                'price_adjustment' => 0.00,
                'stock' => 30,
                'is_active' => true
            ],
            [
                'product_variant_id' => 2,
                'name' => 'Thick Crust',
                'price_adjustment' => 2.00,
                'stock' => 30,
                'is_active' => true
            ],
            // Burger Cook Levels
            [
                'product_variant_id' => 3,
                'name' => 'Medium Rare',
                'price_adjustment' => 0.00,
                'stock' => 10,
                'is_active' => true
            ],
            [
                'product_variant_id' => 3,
                'name' => 'Medium Well',
                'price_adjustment' => 0.00,
                'stock' => 10,
                'is_active' => true
            ]
        ];

        foreach ($variantOptions as $option) {
            DB::table('variant_options')->insert($option);
        }

        // Product Addons
        $addons = [
            // For Pizza
            [
                'product_id' => 1,
                'name' => 'Extra Cheese',
                'price' => 2.50,
                'stock' => 100,
                'is_active' => true
            ],
            [
                'product_id' => 1,
                'name' => 'Mushrooms',
                'price' => 1.50,
                'stock' => 50,
                'is_active' => true
            ],
            // For Burger
            [
                'product_id' => 2,
                'name' => 'Extra Patty',
                'price' => 3.99,
                'stock' => 30,
                'is_active' => true
            ],
            [
                'product_id' => 2,
                'name' => 'Bacon',
                'price' => 2.50,
                'stock' => 40,
                'is_active' => true
            ]
        ];

        foreach ($addons as $addon) {
            DB::table('product_addons')->insert($addon);
        }
    }
}

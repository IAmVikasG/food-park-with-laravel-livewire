<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product Categories - Real Data
        $productCategories = [
            [
                'name' => 'Pizzas',
                'slug' => 'pizzas',
                'type' => 'product',
                'description' => 'Our handcrafted pizzas made with fresh ingredients',
                'meta_title' => 'Pizzas - Handcrafted Pies Made with Fresh Ingredients',
                'meta_description' => 'Explore our wide range of handcrafted pizzas made with fresh ingredients, perfect for any occasion',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Pastas',
                'slug' => 'pastas',
                'type' => 'product',
                'description' => 'Authentic Italian pasta dishes',
                'meta_title' => 'Pastas - Authentic Italian Pasta Dishes',
                'meta_description' => 'Discover our authentic Italian pasta dishes, crafted with love and care to transport you to Italy',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Salads',
                'slug' => 'salads',
                'type' => 'product',
                'description' => 'Fresh and healthy salad options',
                'meta_title' => 'Salads - Fresh and Healthy Options for a Light Meal',
                'meta_description' => 'Enjoy our fresh and healthy salad options, perfect for a light and refreshing meal',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Beverages',
                'slug' => 'beverages',
                'type' => 'product',
                'description' => 'Refreshing drinks and sodas',
                'meta_title' => 'Beverages - Refreshing Drinks and Sodas',
                'meta_description' => 'Quench your thirst with our refreshing drinks and sodas, perfect for any occasion',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Desserts',
                'slug' => 'desserts',
                'type' => 'product',
                'description' => 'Sweet treats to complete your meal',
                'meta_title' => 'Desserts - Sweet Treats to Complete Your Meal',
                'meta_description' => 'Indulge in our sweet treats, perfect for completing your meal and satisfying your sweet tooth',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        // Blog Categories - Real Data
        $blogCategories = [
            [
                'name' => 'Tech News',
                'slug' => 'tech-news',
                'type' => 'blog',
                'description' => 'Latest technology news and updates',
                'meta_title' => 'Technology News and Updates',
                'meta_description' => 'Stay updated with the latest technology news and trends',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Style Guide',
                'slug' => 'style-guide',
                'type' => 'blog',
                'description' => 'Fashion tips and style guides',
                'meta_title' => 'Style Guides & Fashion Tips',
                'meta_description' => 'Learn about the latest fashion trends and styling tips',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Product Reviews',
                'slug' => 'product-reviews',
                'type' => 'blog',
                'description' => 'In-depth product reviews and comparisons',
                'meta_title' => 'Product Reviews and Comparisons',
                'meta_description' => 'Detailed reviews of our products and comparisons',
                'is_active' => true,
                'sort_order' => 3,
            ]
        ];

        // Insert real data
        foreach (array_merge($productCategories, $blogCategories) as $category) {
            Category::create($category);
        }

        // Generate dummy data using factory
        
        // Category::factory()->count(3)->create(['type' => 'product']);
        // Category::factory()->count(3)->create(['type' => 'blog']);
    }
}

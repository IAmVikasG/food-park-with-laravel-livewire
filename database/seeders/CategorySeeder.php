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
                'name' => 'Electronics',
                'slug' => 'electronics',
                'type' => 'product',
                'description' => 'All electronic devices and accessories',
                'meta_title' => 'Electronics - Shop the Latest Devices',
                'meta_description' => 'Explore our wide range of electronics including smartphones, laptops, and accessories',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'type' => 'product',
                'description' => 'Latest smartphones from top brands',
                'parent_id' => 1, // Will reference Electronics
                'meta_title' => 'Smartphones - Latest Models',
                'meta_description' => 'Browse the latest smartphones from Apple, Samsung, and more',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'type' => 'product',
                'description' => 'Professional and gaming laptops',
                'parent_id' => 1, // Will reference Electronics
                'meta_title' => 'Laptops - Gaming & Professional',
                'meta_description' => 'Find the perfect laptop for work or gaming',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'type' => 'product',
                'description' => 'Clothing, shoes, and accessories',
                'meta_title' => 'Fashion - Latest Trends',
                'meta_description' => 'Discover the latest fashion trends and styles',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => "Men's Wear",
                'slug' => 'mens-wear',
                'type' => 'product',
                'description' => 'Clothing and accessories for men',
                'parent_id' => 4, // Will reference Fashion
                'meta_title' => "Men's Fashion Collection",
                'meta_description' => 'Explore our collection of men\'s clothing and accessories',
                'is_active' => true,
                'sort_order' => 1,
            ]
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
        Category::factory()->count(3)->create(['type' => 'product']);
        Category::factory()->count(3)->create(['type' => 'blog']);
    }
}

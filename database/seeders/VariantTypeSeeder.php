<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\VariantOption;
use App\Models\VariantType;

class VariantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variantTypes = [
            'Size' => ['Small' => -2.00, 'Medium' => 0.00, 'Large' => 3.00, 'Extra Large' => 5.00],
            'Crust' => ['Thin' => 0.00, 'Thick' => 1.00, 'Stuffed' => 3.00, 'Gluten-Free' => 2.50],
            'Extra Cheese' => ['Yes' => 2.00, 'No' => 0.00],
        ];

        foreach ($variantTypes as $typeName => $options) {
            $type = VariantType::create(['name' => $typeName]);

            foreach ($options as $optionName => $priceAdjustment) {
                $option = VariantOption::create([
                    'variant_type_id' => $type->id,
                    'name' => $optionName,
                ]);

                // Add variants to all pizza products
                Product::where('category_id', 1)->get()->each(function ($product) use ($option, $priceAdjustment, $optionName) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'variant_option_id' => $option->id,
                        'price_adjustment' => $priceAdjustment,
                        'is_default' => $optionName === 'Medium' || $optionName === 'Thin' || $optionName === 'No',
                    ]);
                });
            }
        }
    }
}

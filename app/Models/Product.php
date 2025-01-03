<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock',
        'is_active',
        'prep_time',
        'meta_title',
        'meta_description',
        'featured',
        'additional_charges',
        'tax_rules'
    ];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images')
        ->useFallbackUrl('/images/placeholder.jpg')
        ->registerMediaConversions(function (Media $media) {
            $this->addMediaConversion('thumb')
                ->width(200)
                ->height(200);

            $this->addMediaConversion('medium')
                ->width(800)
                ->height(600);
        });
    }
}

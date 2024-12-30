<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\SliderFactory> */
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'offer',
        'title',
        'subtitle',
        'description',
        'btn_link',
        'order',
        'is_active',
        'created_by',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('slider_images')->singleFile();
    }
}

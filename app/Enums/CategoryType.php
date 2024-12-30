<?php


namespace App\Enums;

enum CategoryType: string
{
    case Product = 'product';
    case Blog = 'blog';

    public function label(): string
    {
        return match ($this) {
            self::Product => 'Product Category Type',
            self::Blog => 'Product Category Type',
        };
    }
}

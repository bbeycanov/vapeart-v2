<?php

namespace App\Enums;

enum DiscountType: string
{
    case FIXED = 'fixed';
    case PERCENTAGE = 'percentage';


    /**
     * @return array
     */
    public static function toArray(): array
    {
        return [
            self::FIXED->value,
            self::PERCENTAGE->value,
        ];
    }

    /**
     * @return array
     */
    public static function getNames(): array
    {
        return [
            self::FIXED->value => __('Fixed Amount'),
            self::PERCENTAGE->value => __('Percentage'),
        ];
    }
}

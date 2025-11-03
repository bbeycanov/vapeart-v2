<?php

namespace App\Enums;

enum UrlTarget: string
{
    case SAME_TAB = '_self';
    case NEW_TAB = '_blank';

    /**
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::SAME_TAB->value => __('Same Tab'),
            self::NEW_TAB->value => __('New Tab'),
        ];
    }
}

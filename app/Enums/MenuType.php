<?php

namespace App\Enums;

enum MenuType: string
{
    case NORMAL_LINK = 'normal';
    case DROPDOWN = 'dropdown';
    case MEGA_MENU = 'mega';

    /**
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::NORMAL_LINK->value => __('Normal Link'),
            self::DROPDOWN->value => __('Dropdown'),
            self::MEGA_MENU->value => __('Mega Menu'),
        ];
    }
}

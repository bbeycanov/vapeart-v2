<?php

namespace App\Enums;

enum MenuPosition: string
{
    case HEADER     = 'header';
    case TOP_HEADER = 'top_header';
    case FOOTER     = 'footer';
    case SIDEBAR    = 'sidebar';
    case FEATURED    = 'featured';
    case MOBILE_MENU = 'mobile_menu';

    /**
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::HEADER->value => __('Header'),
            self::TOP_HEADER->value => __('Top Header'),
            self::FOOTER->value => __('Footer'),
            self::SIDEBAR->value => __('Sidebar'),
            self::FEATURED->value => __('Featured'),
            self::MOBILE_MENU->value => __('Mobile Menu'),
        ];
    }
}

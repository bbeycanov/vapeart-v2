<?php

namespace App\Enums;

enum BannerType: string
{
    case IMAGE = 'image';      // simple image (banner)
    case SLIDE = 'slide';      // slider item (hero)
    case FEATURE = 'feature';  // icon + title + short text (feature strip in the picture)
    case VIDEO = 'video';      // video (optional)
    case HTML = 'html';        // custom html (service strip)

    /**
     * @return array
     */
    public static function getNames(): array
    {
        return [
            self::IMAGE->value => __('Image'),
            self::SLIDE->value => __('Slide'),
            self::FEATURE->value => __('Feature'),
            self::VIDEO->value => __('Video'),
            self::HTML->value => __('HTML'),
        ];
    }
}

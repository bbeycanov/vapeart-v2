<?php

namespace App\Enums;

enum BannerPosition: string
{
    // HOME
    case HOME_HERO_SLIDESHOW = 'home_hero_slideshow';    // Ana səhifə swiper/slide, böyük hero

    // SHOP / CATALOG
    case SHOP_TOP_BANNER = 'shop_top_banner';            // Kateqoriya/Shop səhifəsinin üst banneri

    // GENERIC PAGES
    case PAGE_HEADER = 'page_header';                    // About/Contact kimi səhifələrdə başlıq/hero sahəsi
    case BLOG_INDEX_HEADER = 'blog_index_header';        // Blog index səhifəsinin üst banneri

    /**
     * @return array
     */
    public static function getNames(): array
    {
        return [
            self::HOME_HERO_SLIDESHOW->value => __('Home Hero Slideshow'),
            self::SHOP_TOP_BANNER->value => __('Shop Top Banner'),
            self::PAGE_HEADER->value => __('Page Header'),
            self::BLOG_INDEX_HEADER->value => __('Blog Index Header'),
        ];
    }
}

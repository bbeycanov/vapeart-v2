<?php

namespace App\Enums;

enum BannerPosition: string
{
    // HOME
    case HOME_HERO_SLIDESHOW = 'home_hero_slideshow';    // ana səhifə swiper/slide, böyük hero. :contentReference[oaicite:0]{index=0}
    case HOME_SERVICE_STRIP = 'home_service_strip';      // ikonlu feature-lər şeridi. :contentReference[oaicite:1]{index=1}
    case HOME_CATEGORY_STRIP = 'home_category_strip';    // kateqoriya slider/karusel. :contentReference[oaicite:2]{index=2}
    case HOME_BLOG_STRIP = 'home_blog_strip';            // “From our blog”/blog karuseli. :contentReference[oaicite:3]{index=3}
    case HOME_NEWSLETTER_CTA = 'home_newsletter_cta';    // temalı CTA blok (newsletter/CTA sahəsi). :contentReference[oaicite:4]{index=4}

    // SHOP / CATALOG
    case SHOP_TOP_BANNER = 'shop_top_banner';            // kateqoriya səhifəsinin üst banneri. :contentReference[oaicite:5]{index=5}

    // GENERIC PAGES
    case PAGE_HEADER = 'page_header';                    // About/Contact kimi səhifələrdə başlıq/hero sahəsi. :contentReference[oaicite:6]{index=6}
    case BRANDS_CAROUSEL = 'brands_carousel';            // tərəfdaş/brand zolağı (istəsən ayrıca banner kimi idarə olunsun). :contentReference[oaicite:7]{index=7}

    // PRODUCT
    case PRODUCT_SIDEBAR = 'product_sidebar';            // məhsul səhifəsində side banner/promo (yer saxlanıb).

    // NAVIGATION
    case MEGA_MENU_MEDIA = 'mega_menu_media';            // mega menu-nun media paneli (sağda şəkil/video bloku). :contentReference[oaicite:8]{index=8}

    // FOOTER
    case FOOTER_PROMO = 'footer_promo';                  // footer-önü/sonundakı promo blokları (ikon social-lar yanında məlumat). :contentReference[oaicite:9]{index=9}


    /**
     * @return array
     */
    public static function getNames(): array
    {
        return [
            self::HOME_HERO_SLIDESHOW->value => __('Home Hero Slideshow'),
            self::HOME_SERVICE_STRIP->value => __('Home Service Strip'),
            self::HOME_CATEGORY_STRIP->value => __('Home Category Strip'),
            self::HOME_BLOG_STRIP->value => __('Home Blog Strip'),
            self::HOME_NEWSLETTER_CTA->value => __('Home Newsletter CTA'),
            self::SHOP_TOP_BANNER->value => __('Shop Top Banner'),
            self::PAGE_HEADER->value => __('Page Header'),
            self::BRANDS_CAROUSEL->value => __('Brands Carousel'),
            self::PRODUCT_SIDEBAR->value => __('Product Sidebar'),
            self::MEGA_MENU_MEDIA->value => __('Mega Menu Media'),
            self::FOOTER_PROMO->value => __('Footer Promo'),
        ];
    }
}

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default SEO Settings
    |--------------------------------------------------------------------------
    |
    | These are the default SEO settings used throughout the application.
    | They can be overridden on a per-page basis using blade sections.
    |
    */

    'defaults' => [
        'title' => env('APP_NAME', 'VapeArt Baku'),
        'title_separator' => ' | ',
        'description' => 'VapeArt Baku - Electronic cigarettes, vape devices, snus and premium tobacco products store in Baku.',
        'keywords' => 'vape, electronic cigarette, snus, tobacco, vape baku, elfbar, vozol, hqd, nicotine',
        'robots' => 'index, follow',
        'canonical' => null, // Will use current URL if null
    ],

    /*
    |--------------------------------------------------------------------------
    | Open Graph Settings
    |--------------------------------------------------------------------------
    */

    'open_graph' => [
        'type' => 'website',
        'site_name' => env('APP_NAME', 'VapeArt Baku'),
        'image' => '/storefront/images/og-image.jpg',
        'image_width' => 1200,
        'image_height' => 630,
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Card Settings
    |--------------------------------------------------------------------------
    */

    'twitter' => [
        'card' => 'summary_large_image',
        'site' => null, // @username
        'creator' => null, // @username
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema.org Settings
    |--------------------------------------------------------------------------
    */

    'schema' => [
        'organization' => [
            'type' => 'Organization',
            'name' => env('APP_NAME', 'VapeArt Baku'),
            'legal_name' => 'VapeArt Baku MMC',
            'founding_date' => '2020',
            'founders' => [],
        ],
        'local_business' => [
            'type' => 'Store',
            'price_range' => '$$',
            'currencies_accepted' => 'AZN',
            'payment_accepted' => 'Cash, Credit Card',
            'opening_hours' => 'Mo-Su 10:00-22:00',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Robots.txt Settings
    |--------------------------------------------------------------------------
    */

    'robots' => [
        'disallow' => [
            '/admin',
            '/admin/',
            '/dashboard',
            '/api',
            '/api/',
            '/storage/',
            '/login',
            '/register',
            '/password/',
        ],
        'allow' => [
            '/storefront/',
            '/images/',
        ],
        'sitemap' => '/sitemap.xml',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap Settings
    |--------------------------------------------------------------------------
    */

    'sitemap' => [
        'enabled' => true,
        'cache_duration' => 3600, // 1 hour
        'priorities' => [
            'home' => 1.0,
            'categories' => 0.8,
            'products' => 0.7,
            'brands' => 0.6,
            'pages' => 0.5,
            'blogs' => 0.5,
        ],
        'frequencies' => [
            'home' => 'daily',
            'categories' => 'weekly',
            'products' => 'weekly',
            'brands' => 'monthly',
            'pages' => 'monthly',
            'blogs' => 'weekly',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Structured Data Settings
    |--------------------------------------------------------------------------
    */

    'structured_data' => [
        'breadcrumbs' => true,
        'product' => true,
        'organization' => true,
        'website' => true,
        'search_action' => true,
        'local_business' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Media Profiles
    |--------------------------------------------------------------------------
    */

    'social' => [
        'facebook' => env('SOCIAL_FACEBOOK'),
        'instagram' => env('SOCIAL_INSTAGRAM'),
        'twitter' => env('SOCIAL_TWITTER'),
        'youtube' => env('SOCIAL_YOUTUBE'),
        'tiktok' => env('SOCIAL_TIKTOK'),
        'linkedin' => env('SOCIAL_LINKEDIN'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance & Technical SEO
    |--------------------------------------------------------------------------
    */

    'performance' => [
        'preconnect' => [
            'https://fonts.googleapis.com',
            'https://fonts.gstatic.com',
        ],
        'dns_prefetch' => [
            'https://fonts.googleapis.com',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | PWA Settings
    |--------------------------------------------------------------------------
    */

    'pwa' => [
        'enabled' => true,
        'name' => env('APP_NAME', 'VapeArt Baku'),
        'short_name' => 'VapeArt',
        'description' => 'VapeArt Baku - Premium vape products',
        'theme_color' => '#000000',
        'background_color' => '#ffffff',
        'display' => 'standalone',
        'orientation' => 'portrait',
        'start_url' => '/',
        'scope' => '/',
    ],

    /*
    |--------------------------------------------------------------------------
    | Localization SEO
    |--------------------------------------------------------------------------
    */

    'localization' => [
        'default_locale' => 'az',
        'supported_locales' => ['az', 'en', 'ru'],
        'hreflang_enabled' => true,
        'x_default' => 'az',
    ],
];

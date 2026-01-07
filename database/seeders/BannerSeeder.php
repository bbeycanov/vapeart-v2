<?php

namespace Database\Seeders;

use App\Enums\BannerPosition;
use App\Enums\BannerType;
use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        // HOME HERO SLIDESHOW - Banner 1
        Banner::updateOrCreate(
            [
                'position' => BannerPosition::HOME_HERO_SLIDESHOW->value,
                'key' => 'home-hero-1'
            ],
            [
                'type' => BannerType::SLIDE->value,
                'title' => [
                    'en' => 'Premium Vape Collection',
                    'az' => 'Premium Vape Kolleksiyası',
                    'ru' => 'Премиум Vape Коллекция'
                ],
                'subtitle' => [
                    'en' => 'Discover the Best',
                    'az' => 'Ən yaxşısını kəşf edin',
                    'ru' => 'Откройте лучшее'
                ],
                'content' => [
                    'en' => 'Explore our wide range of premium vaping devices and e-liquids',
                    'az' => 'Premium vaping cihazları və e-mayelərimizi kəşf edin',
                    'ru' => 'Исследуйте наш широкий ассортимент премиальных устройств и жидкостей'
                ],
                'link_text' => [
                    'en' => 'Shop Now',
                    'az' => 'İndi al',
                    'ru' => 'Купить сейчас'
                ],
                'link_url' => [
                    'en' => '/en/products',
                    'az' => '/az/products',
                    'ru' => '/ru/products'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // HOME HERO SLIDESHOW - Banner 2
        Banner::updateOrCreate(
            [
                'position' => BannerPosition::HOME_HERO_SLIDESHOW->value,
                'key' => 'home-hero-2'
            ],
            [
                'type' => BannerType::SLIDE->value,
                'title' => [
                    'en' => 'New Arrivals',
                    'az' => 'Yeni Gələnlər',
                    'ru' => 'Новые поступления'
                ],
                'subtitle' => [
                    'en' => 'Latest Products',
                    'az' => 'Ən son məhsullar',
                    'ru' => 'Последние товары'
                ],
                'content' => [
                    'en' => 'Check out our newest vape devices and accessories',
                    'az' => 'Ən yeni vape cihazları və aksesuarlarımıza baxın',
                    'ru' => 'Ознакомьтесь с нашими новейшими устройствами и аксессуарами'
                ],
                'link_text' => [
                    'en' => 'View Collection',
                    'az' => 'Kolleksiyaya bax',
                    'ru' => 'Смотреть коллекцию'
                ],
                'link_url' => [
                    'en' => '/en/new-products',
                    'az' => '/az/new-products',
                    'ru' => '/ru/new-products'
                ],
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        // HOME HERO SLIDESHOW - Banner 3
        Banner::updateOrCreate(
            [
                'position' => BannerPosition::HOME_HERO_SLIDESHOW->value,
                'key' => 'home-hero-3'
            ],
            [
                'type' => BannerType::SLIDE->value,
                'title' => [
                    'en' => 'Special Offers',
                    'az' => 'Xüsusi Təkliflər',
                    'ru' => 'Специальные предложения'
                ],
                'subtitle' => [
                    'en' => 'Limited Time',
                    'az' => 'Məhdud müddət',
                    'ru' => 'Ограниченное время'
                ],
                'content' => [
                    'en' => 'Grab amazing deals on selected vape products',
                    'az' => 'Seçilmiş vape məhsullarında möhtəşəm endirimlər',
                    'ru' => 'Получите удивительные скидки на избранные товары'
                ],
                'link_text' => [
                    'en' => 'View Offers',
                    'az' => 'Təkliflərə bax',
                    'ru' => 'Смотреть предложения'
                ],
                'link_url' => [
                    'en' => '/en/discounts',
                    'az' => '/az/discounts',
                    'ru' => '/ru/discounts'
                ],
                'is_active' => true,
                'sort_order' => 3,
            ]
        );

        // SHOP TOP BANNER
        Banner::updateOrCreate(
            [
                'position' => BannerPosition::SHOP_TOP_BANNER->value,
                'key' => 'shop-top-banner'
            ],
            [
                'type' => BannerType::IMAGE->value,
                'title' => [
                    'en' => 'Shop All Products',
                    'az' => 'Bütün Məhsullar',
                    'ru' => 'Все товары'
                ],
                'subtitle' => [
                    'en' => 'Find your perfect vape',
                    'az' => 'Mükəmməl vape-inizi tapın',
                    'ru' => 'Найдите свой идеальный вейп'
                ],
                'link_url' => [
                    'en' => '/en/products',
                    'az' => '/az/products',
                    'ru' => '/ru/products'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // PAGE HEADER - Contact
        Banner::updateOrCreate(
            [
                'position' => BannerPosition::PAGE_HEADER->value,
                'key' => 'contact-page-header'
            ],
            [
                'type' => BannerType::IMAGE->value,
                'title' => [
                    'en' => 'Contact Us',
                    'az' => 'Bizimlə Əlaqə',
                    'ru' => 'Связаться с нами'
                ],
                'subtitle' => [
                    'en' => 'We\'re here to help',
                    'az' => 'Sizə kömək etmək üçün buradayıq',
                    'ru' => 'Мы здесь, чтобы помочь'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // PAGE HEADER - About
        Banner::updateOrCreate(
            [
                'position' => BannerPosition::PAGE_HEADER->value,
                'key' => 'about-page-header'
            ],
            [
                'type' => BannerType::IMAGE->value,
                'title' => [
                    'en' => 'About Us',
                    'az' => 'Haqqımızda',
                    'ru' => 'О нас'
                ],
                'subtitle' => [
                    'en' => 'Our Story',
                    'az' => 'Bizim hekayəmiz',
                    'ru' => 'Наша история'
                ],
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        // BLOG INDEX HEADER
        Banner::updateOrCreate(
            [
                'position' => BannerPosition::BLOG_INDEX_HEADER->value,
                'key' => 'blog-index-header'
            ],
            [
                'type' => BannerType::IMAGE->value,
                'title' => [
                    'en' => 'Vape Blog',
                    'az' => 'Vape Bloq',
                    'ru' => 'Vape Блог'
                ],
                'subtitle' => [
                    'en' => 'News, Tips & Guides',
                    'az' => 'Xəbərlər, Məsləhətlər və Bələdçilər',
                    'ru' => 'Новости, советы и руководства'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
    }
}

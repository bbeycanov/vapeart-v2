<?php

namespace Database\Seeders;

use App\Enums\BannerPosition;
use App\Enums\BannerType;
use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        // HOME HERO (slider)
        $hero = Banner::updateOrCreate(
            [
                'position' => BannerPosition::HOME_HERO_SLIDESHOW->value,
                'key' => 'home-hero-1'
            ],
            [
                'type' => BannerType::SLIDE->value,
                'title' => [
                    'en' => 'Fresh Hand-Picked Vegetables',
                    'az' => 'Əl ilə seçilmiş təzə tərəvəzlər',
                    'ru' => 'Свежие отборные овощи'
                ],
                'subtitle' => [
                    'en' => 'Everyday',
                    'az' => 'Hər gün',
                    'ru' => 'Каждый день'
                ],
                'link_text' => [
                    'en' => 'Discover More',
                    'az' => 'Daha çox',
                    'ru' => 'Узнать больше'
                ],
                'link_url' => [
                    'en' => '/shop',
                    'az' => '/az/shop',
                    'ru' => '/ru/shop'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
        // media (slide 1)
        if (!$hero->hasMedia('banner')) {
            //$hero->addMedia(Storage::path('seeds/hero_1.jpg'))->preservingOriginal()->toMediaCollection('banner');
            //$hero->addMedia(Storage::path('seeds/hero_2.jpg'))->preservingOriginal()->toMediaCollection('banner');
        }

        // HOME SERVICE STRIP (HTML)
        Banner::updateOrCreate(
            [
                'position' => BannerPosition::HOME_SERVICE_STRIP->value,
                'key' => 'home-service-strip'
            ],
            [
                'type' => BannerType::HTML->value,
                'html' => [
                    'en' => '<div class="service-promotion">…</div>',
                    'az' => '<div class="service-promotion">…</div>'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // SHOP TOP BANNER (image)
        $shop = Banner::updateOrCreate(
            [
                'position' => BannerPosition::SHOP_TOP_BANNER->value,
                'key' => 'shop-top'
            ],
            [
                'type' => BannerType::IMAGE->value,
                'title' => [
                    'en' => 'Jackets & Coats',
                    'az' => 'Kurtkalar və Paltolar'
                ],
                'link_url' => [
                    'en' => '/shop/jackets-coats',
                    'az' => '/az/shop/jackets-coats'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
        if (!$shop->hasMedia('banner')) {
            //$shop->addMedia(Storage::path('seeds/shop_top.jpg'))->preservingOriginal()->toMediaCollection('banner');
        }

        // PAGE HEADER example (Contact)
        Banner::updateOrCreate(
            [
                'position' => BannerPosition::PAGE_HEADER->value,
                'key' => 'contact-header'
            ],
            [
                'type' => BannerType::HTML->value,
                'title' => [
                    'en' => 'Contact Us',
                    'az' => 'Bizimlə əlaqə'
                ],
                'html' => [
                    'en' => '<h2 class="page-title">CONTACT US</h2>',
                    'az' => '<h2 class="page-title">ƏLAQƏ</h2>'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
    }
}

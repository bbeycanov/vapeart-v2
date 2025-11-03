<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Widget;
use App\Enums\MenuType;
use App\Enums\MenuPosition;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $home = Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Ana səhifə',
                'en' => 'Home',
                'ru' => 'Главная'
            ],
            'url' => [
                'az' => '/',
                'en' => '/',
                'ru' => '/'
            ],
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // HEADER: Dropdown
        $products = Menu::create([
            'parent_id' => null,
            'type' => MenuType::DROPDOWN->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Məhsullar',
                'en' => 'Products',
                'ru' => 'Продукты'
            ],
            'url' => [
                'az' => '/products',
                'en' => '/products',
                'ru' => '/products'
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Menu::create([
            'parent_id' => $products->id,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Pod Sistemlər',
                'en' => 'Pod Systems',
                'ru' => 'Под системы'
            ],
            'url' => [
                'az' => '/products/pod-systems',
                'en' => '/products/pod-systems',
                'ru' => '/products/pod-systems'
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Menu::create([
            'parent_id' => $products->id,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Likvidlər',
                'en' => 'Liquids',
                'ru' => 'Жидкости'
            ],
            'url' => [
                'az' => '/products/liquids',
                'en' => '/products/liquids',
                'ru' => '/products/liquids'
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // HEADER: Mega Menu
        $collections = Menu::create([
            'parent_id' => null,
            'type' => MenuType::MEGA_MENU->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Kolleksiyalar',
                'en' => 'Collections',
                'ru' => 'Коллекции'
            ],
            'url' => [
                'az' => '/collections',
                'en' => '/collections',
                'ru' => '/collections'
            ],
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // Mega children (nested)
        $summer = Menu::create([
            'parent_id' => $collections->id,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Yay seçimi',
                'en' => 'Summer Picks',
                'ru' => 'Летний выбор'
            ],
            'url' => [
                'az' => '/collections/summer',
                'en' => '/collections/summer',
                'ru' => '/collections/summer'
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Menu::create([
            'parent_id' => $summer->id,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Mentol',
                'en' => 'Menthol',
                'ru' => 'Ментол'
            ],
            'url' => [
                'az' => '/collections/summer/menthol',
                'en' => '/collections/summer/menthol',
                'ru' => '/collections/summer/menthol'
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Menu::create([
            'parent_id' => $collections->id,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Dessert',
                'en' => 'Dessert',
                'ru' => 'Десерт'
            ],
            'url' => [
                'az' => '/collections/dessert',
                'en' => '/collections/dessert',
                'ru' => '/collections/dessert'
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // Mega Menu Widget (banner)
        $widget = Widget::create([
            'title' => [
                'az' => 'Yeni Gələnlər',
                'en' => 'New Arrivals',
                'ru' => 'Новинки'
            ],
            'content' => [
                'az' => 'Yeni kolleksiyamızı kəşf edin!',
                'en' => 'Discover our new collection!',
                'ru' => 'Откройте для себя нашу новую коллекцию!'
            ],
            'button_text' => [
                'az' => 'İndi al',
                'en' => 'Shop Now',
                'ru' => 'Купить сейчас'
            ],
            'button_url' => [
                'az' => '/collections/new-arrivals',
                'en' => '/collections/new-arrivals',
                'ru' => '/collections/new-arrivals'
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);
        // Şəkil əlavə etmək üçün (opsional):
        $widget->addMediaFromUrl('https://picsum.photos/800/300')->toMediaCollection('image');

        $collections->widgets()->attach($widget->id);

        // FOOTER: Normal linklər
        Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::FOOTER->value,
            'title' => [
                'az' => 'Haqqımızda',
                'en' => 'About',
                'ru' => 'О нас'
            ],
            'url' => [
                'az' => '/about',
                'en' => '/about',
                'ru' => '/about'
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::FOOTER->value,
            'title' => [
                'az' => 'Əlaqə',
                'en' => 'Contact',
                'ru' => 'Контакты'
            ],
            'url' => [
                'az' => '/contact',
                'en' => '/contact',
                'ru' => '/contact'
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::FEATURED->value,
            'title' => [
                'az' => 'Ən çox satılanlar',
                'en' => 'Best Sellers',
                'ru' => 'Бестселлеры'
            ],
            'url' => [
                'az' => '#best-sellers',
                'en' => '#best-sellers',
                'ru' => '#best-sellers'
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::FEATURED->value,
            'title' => [
                'az' => 'Ən populyar',
                'en' => 'Most Popular',
                'ru' => 'Самые популярные'
            ],
            'url' => [
                'az' => '#most-popular',
                'en' => '#most-popular',
                'ru' => '#most-popular'
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::FEATURED->value,
            'title' => [
                'az' => 'Top 20',
                'en' => 'Top 20',
                'ru' => 'Топ 20'
            ],
            'url' => [
                'az' => '#top-20',
                'en' => '#top-20',
                'ru' => '#top-20'
            ],
            'is_active' => true,
            'sort_order' => 3,
        ]);

        Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::FEATURED->value,
            'title' => [
                'az' => 'Ən yaxşı qiymətləndirilənlər',
                'en' => 'Best Rated',
                'ru' => 'Лучшие по рейтингу'
            ],
            'url' => [
                'az' => '#best-rated',
                'en' => '#best-rated',
                'ru' => '#best-rated'
            ],
            'is_active' => true,
            'sort_order' => 4,
        ]);
    }
}

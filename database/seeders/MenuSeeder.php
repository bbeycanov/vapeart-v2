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
        // ============================================
        // FEATURED MENUS
        // ============================================
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

        // SIDEBAR: Kategoriyalar
        $birdəfəlik = Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::SIDEBAR->value,
            'title' => [
                'az' => 'Birdəfəlik',
                'en' => 'Disposable',
                'ru' => 'Одноразовые'
            ],
            'url' => [
                'az' => '/categories?filter=birdəfəlik',
                'en' => '/categories?filter=disposable',
                'ru' => '/categories?filter=disposable'
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Birdəfəlik children
        $birdəfəlikChildren = [
            ['az' => 'Vozol', 'en' => 'Vozol', 'ru' => 'Vozol'],
            ['az' => 'Elfbar', 'en' => 'Elfbar', 'ru' => 'Elfbar'],
            ['az' => 'HQD', 'en' => 'HQD', 'ru' => 'HQD'],
            ['az' => 'Waka', 'en' => 'Waka', 'ru' => 'Waka'],
            ['az' => 'CoolPlay', 'en' => 'CoolPlay', 'ru' => 'CoolPlay'],
            ['az' => 'Pura', 'en' => 'Pura', 'ru' => 'Pura'],
            ['az' => 'Mocig', 'en' => 'Mocig', 'ru' => 'Mocig'],
            ['az' => 'Mosmo', 'en' => 'Mosmo', 'ru' => 'Mosmo'],
            ['az' => 'Imoment', 'en' => 'Imoment', 'ru' => 'Imoment'],
            ['az' => 'Plonq', 'en' => 'Plonq', 'ru' => 'Plonq'],
            ['az' => 'Oxbar', 'en' => 'Oxbar', 'ru' => 'Oxbar'],
            ['az' => 'Chillax', 'en' => 'Chillax', 'ru' => 'Chillax'],
        ];

        foreach ($birdəfəlikChildren as $index => $child) {
            Menu::create([
                'parent_id' => $birdəfəlik->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::SIDEBAR->value,
                'title' => [
                    'az' => $child['az'],
                    'en' => $child['en'],
                    'ru' => $child['ru']
                ],
                'url' => [
                    'az' => '/products?brand=' . strtolower($child['az']),
                    'en' => '/products?brand=' . strtolower($child['en']),
                    'ru' => '/products?brand=' . strtolower($child['ru'])
                ],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        $cihazlar = Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::SIDEBAR->value,
            'title' => [
                'az' => 'Cihazlar',
                'en' => 'Devices',
                'ru' => 'Устройства'
            ],
            'url' => [
                'az' => '/categories?filter=cihazlar',
                'en' => '/categories?filter=devices',
                'ru' => '/categories?filter=devices'
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // Cihazlar children
        $cihazlarChildren = [
            ['az' => 'Elektron siqaret', 'en' => 'Electronic cigarette', 'ru' => 'Электронная сигарета'],
            ['az' => 'Elektron qəlyan', 'en' => 'Electronic hookah', 'ru' => 'Электронный кальян'],
            ['az' => 'Kartric və filterlər', 'en' => 'Cartridges and filters', 'ru' => 'Картриджи и фильтры'],
        ];

        foreach ($cihazlarChildren as $index => $child) {
            Menu::create([
                'parent_id' => $cihazlar->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::SIDEBAR->value,
                'title' => [
                    'az' => $child['az'],
                    'en' => $child['en'],
                    'ru' => $child['ru']
                ],
                'url' => [
                    'az' => '/categories?filter=' . strtolower(str_replace([' ', 'ə'], ['-', 'e'], $child['az'])),
                    'en' => '/categories?filter=' . strtolower(str_replace(' ', '-', $child['en'])),
                    'ru' => '/categories?filter=' . strtolower(str_replace(' ', '-', $child['ru']))
                ],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        $snus = Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::SIDEBAR->value,
            'title' => [
                'az' => 'Snus',
                'en' => 'Snus',
                'ru' => 'Снюс'
            ],
            'url' => [
                'az' => '/categories?filter=snus',
                'en' => '/categories?filter=snus',
                'ru' => '/categories?filter=snus'
            ],
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // Snus children
        $snusChildren = [
            ['az' => 'Velo', 'en' => 'Velo', 'ru' => 'Velo'],
            ['az' => 'Iceberg', 'en' => 'Iceberg', 'ru' => 'Iceberg'],
            ['az' => 'Siberia', 'en' => 'Siberia', 'ru' => 'Siberia'],
            ['az' => 'Odens', 'en' => 'Odens', 'ru' => 'Odens'],
            ['az' => 'Pablo', 'en' => 'Pablo', 'ru' => 'Pablo'],
            ['az' => 'Killa', 'en' => 'Killa', 'ru' => 'Killa'],
            ['az' => 'Kurwa', 'en' => 'Kurwa', 'ru' => 'Kurwa'],
        ];

        foreach ($snusChildren as $index => $child) {
            Menu::create([
                'parent_id' => $snus->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::SIDEBAR->value,
                'title' => [
                    'az' => $child['az'],
                    'en' => $child['en'],
                    'ru' => $child['ru']
                ],
                'url' => [
                    'az' => '/products?brand=' . strtolower($child['az']),
                    'en' => '/products?brand=' . strtolower($child['en']),
                    'ru' => '/products?brand=' . strtolower($child['ru'])
                ],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        $siqar = Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::SIDEBAR->value,
            'title' => [
                'az' => 'Siqar & Siqarillalar',
                'en' => 'Cigars & Cigarillos',
                'ru' => 'Сигары и Сигариллы'
            ],
            'url' => [
                'az' => '/categories?filter=siqar-siqarillalar',
                'en' => '/categories?filter=cigars-cigarillos',
                'ru' => '/categories?filter=cigars-cigarillos'
            ],
            'is_active' => true,
            'sort_order' => 4,
        ]);

        // Siqar & Siqarillalar children
        $siqarChildren = [
            ['az' => 'Siqar', 'en' => 'Cigars', 'ru' => 'Сигары'],
            ['az' => 'Siqarillalar', 'en' => 'Cigarillos', 'ru' => 'Сигариллы'],
        ];

        foreach ($siqarChildren as $index => $child) {
            Menu::create([
                'parent_id' => $siqar->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::SIDEBAR->value,
                'title' => [
                    'az' => $child['az'],
                    'en' => $child['en'],
                    'ru' => $child['ru']
                ],
                'url' => [
                    'az' => '/categories?filter=' . strtolower(str_replace([' ', 'ə'], ['-', 'e'], $child['az'])),
                    'en' => '/categories?filter=' . strtolower(str_replace(' ', '-', $child['en'])),
                    'ru' => '/categories?filter=' . strtolower(str_replace(' ', '-', $child['ru']))
                ],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        $maye = Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::SIDEBAR->value,
            'title' => [
                'az' => 'Elektron siqaret mayesi',
                'en' => 'E-liquid',
                'ru' => 'Жидкость для электронных сигарет'
            ],
            'url' => [
                'az' => '/categories?filter=elektron-siqaret-mayesi',
                'en' => '/categories?filter=e-liquid',
                'ru' => '/categories?filter=e-liquid'
            ],
            'is_active' => true,
            'sort_order' => 5,
        ]);

        // Elektron siqaret mayesi children
        $mayeChildren = [
            ['az' => 'Elektron siqaret mayesi', 'en' => 'E-liquid', 'ru' => 'Жидкость для электронных сигарет'],
            ['az' => 'Salt maye', 'en' => 'Salt liquid', 'ru' => 'Солевая жидкость'],
        ];

        foreach ($mayeChildren as $index => $child) {
            Menu::create([
                'parent_id' => $maye->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::SIDEBAR->value,
                'title' => [
                    'az' => $child['az'],
                    'en' => $child['en'],
                    'ru' => $child['ru']
                ],
                'url' => [
                    'az' => '/categories?filter=' . strtolower(str_replace([' ', 'ə'], ['-', 'e'], $child['az'])),
                    'en' => '/categories?filter=' . strtolower(str_replace(' ', '-', $child['en'])),
                    'ru' => '/categories?filter=' . strtolower(str_replace(' ', '-', $child['ru']))
                ],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // ============================================
        // HEADER MENUS
        // ============================================

        // HEADER: Normal Link - HOME
        $headerHome = Menu::create([
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

        // HEADER: Mega Menu - SHOP
        $headerShop = Menu::create([
            'parent_id' => null,
            'type' => MenuType::MEGA_MENU->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Mağaza',
                'en' => 'Shop',
                'ru' => 'Магазин'
            ],
            'url' => [
                'az' => '/products',
                'en' => '/products',
                'ru' => '/products'
            ],
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // SHOP - Shop List (Child Menu - Group Header)
        $shopListGroup = Menu::create([
            'parent_id' => $headerShop->id,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Mağaza Siyahısı',
                'en' => 'Shop List',
                'ru' => 'Список магазинов'
            ],
            'url' => [
                'az' => '#',
                'en' => '#',
                'ru' => '#'
            ],
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // SHOP - Shop List children
        $shopListItems = [
            ['az' => 'Mağaza Siyahısı V1', 'en' => 'Shop List V1', 'ru' => 'Список магазинов V1'],
            ['az' => 'Mağaza Siyahısı V2', 'en' => 'Shop List V2', 'ru' => 'Список магазинов V2'],
            ['az' => 'Mağaza Siyahısı V3', 'en' => 'Shop List V3', 'ru' => 'Список магазинов V3'],
            ['az' => 'Mağaza Siyahısı V4', 'en' => 'Shop List V4', 'ru' => 'Список магазинов V4'],
            ['az' => 'Mağaza Siyahısı V5', 'en' => 'Shop List V5', 'ru' => 'Список магазинов V5'],
            ['az' => 'Mağaza Siyahısı V6', 'en' => 'Shop List V6', 'ru' => 'Список магазинов V6'],
            ['az' => 'Mağaza Siyahısı V7', 'en' => 'Shop List V7', 'ru' => 'Список магазинов V7'],
            ['az' => 'Mağaza Siyahısı V8', 'en' => 'Shop List V8', 'ru' => 'Список магазинов V8'],
            ['az' => 'Mağaza Siyahısı V9', 'en' => 'Shop List V9', 'ru' => 'Список магазинов V9'],
            ['az' => 'Məhsul Üslubu', 'en' => 'Shop Item Style', 'ru' => 'Стиль товара'],
            ['az' => 'Üfüqi Sürüşmə', 'en' => 'Horizontal Scroll', 'ru' => 'Горизонтальная прокрутка'],
        ];

        foreach ($shopListItems as $index => $item) {
            Menu::create([
                'parent_id' => $shopListGroup->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::HEADER->value,
                'title' => [
                    'az' => $item['az'],
                    'en' => $item['en'],
                    'ru' => $item['ru']
                ],
                'url' => [
                    'az' => '/shop-list-v' . ($index + 1),
                    'en' => '/shop-list-v' . ($index + 1),
                    'ru' => '/shop-list-v' . ($index + 1)
                ],
                'target' => '_self',
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // SHOP - Shop Detail (Child Menu - Group Header)
        $shopDetailGroup = Menu::create([
            'parent_id' => $headerShop->id,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Mağaza Detalı',
                'en' => 'Shop Detail',
                'ru' => 'Детали магазина'
            ],
            'url' => [
                'az' => '#',
                'en' => '#',
                'ru' => '#'
            ],
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // SHOP - Shop Detail children
        $shopDetailItems = [
            ['az' => 'Mağaza Detalı V1', 'en' => 'Shop Detail V1', 'ru' => 'Детали магазина V1'],
            ['az' => 'Mağaza Detalı V2', 'en' => 'Shop Detail V2', 'ru' => 'Детали магазина V2'],
            ['az' => 'Mağaza Detalı V3', 'en' => 'Shop Detail V3', 'ru' => 'Детали магазина V3'],
            ['az' => 'Mağaza Detalı V4', 'en' => 'Shop Detail V4', 'ru' => 'Детали магазина V4'],
            ['az' => 'Mağaza Detalı V5', 'en' => 'Shop Detail V5', 'ru' => 'Детали магазина V5'],
            ['az' => 'Mağaza Detalı V6', 'en' => 'Shop Detail V6', 'ru' => 'Детали магазина V6'],
            ['az' => 'Mağaza Detalı V7', 'en' => 'Shop Detail V7', 'ru' => 'Детали магазина V7'],
            ['az' => 'Mağaza Detalı V8', 'en' => 'Shop Detail V8', 'ru' => 'Детали магазина V8'],
            ['az' => 'Mağaza Detalı V9', 'en' => 'Shop Detail V9', 'ru' => 'Детали магазина V9'],
            ['az' => 'Mağaza Detalı V10', 'en' => 'Shop Detail V10', 'ru' => 'Детали магазина V10'],
            ['az' => 'Mağaza Detalı V11', 'en' => 'Shop Detail V11', 'ru' => 'Детали магазина V11'],
        ];

        foreach ($shopDetailItems as $index => $item) {
            Menu::create([
                'parent_id' => $shopDetailGroup->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::HEADER->value,
                'title' => [
                    'az' => $item['az'],
                    'en' => $item['en'],
                    'ru' => $item['ru']
                ],
                'url' => [
                    'az' => '/shop-detail-v' . ($index + 1),
                    'en' => '/shop-detail-v' . ($index + 1),
                    'ru' => '/shop-detail-v' . ($index + 1)
                ],
                'target' => '_self',
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // SHOP - Other Pages (Child Menu - Group Header)
        $otherPagesGroup = Menu::create([
            'parent_id' => $headerShop->id,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Digər Səhifələr',
                'en' => 'Other Pages',
                'ru' => 'Другие страницы'
            ],
            'url' => [
                'az' => '#',
                'en' => '#',
                'ru' => '#'
            ],
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // SHOP - Other Pages children
        $otherPagesItems = [
            ['az' => 'Kolleksiya Şəbəkəsi', 'en' => 'Collection Grid', 'ru' => 'Сетка коллекций'],
            ['az' => 'Sadə Məhsul', 'en' => 'Simple Product', 'ru' => 'Простой товар'],
            ['az' => 'Dəyişkən Məhsul', 'en' => 'Variable Product', 'ru' => 'Вариативный товар'],
            ['az' => 'Xarici Məhsul', 'en' => 'External Product', 'ru' => 'Внешний товар'],
            ['az' => 'Qruplaşdırılmış Məhsul', 'en' => 'Grouped Product', 'ru' => 'Группированный товар'],
            ['az' => 'Endirimdə', 'en' => 'On Sale', 'ru' => 'В продаже'],
            ['az' => 'Stokda Yoxdur', 'en' => 'Out of Stock', 'ru' => 'Нет в наличии'],
            ['az' => 'Alış Səbəti', 'en' => 'Shopping Cart', 'ru' => 'Корзина'],
            ['az' => 'Ödəniş', 'en' => 'Checkout', 'ru' => 'Оформление заказа'],
            ['az' => 'Sifariş Tamamlandı', 'en' => 'Order Complete', 'ru' => 'Заказ завершен'],
            ['az' => 'Sifariş İzləmə', 'en' => 'Order Tracking', 'ru' => 'Отслеживание заказа'],
        ];

        foreach ($otherPagesItems as $index => $item) {
            Menu::create([
                'parent_id' => $otherPagesGroup->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::HEADER->value,
                'title' => [
                    'az' => $item['az'],
                    'en' => $item['en'],
                    'ru' => $item['ru']
                ],
                'url' => [
                    'az' => '/other-pages/' . strtolower(str_replace([' ', 'ə'], ['-', 'e'], $item['az'])),
                    'en' => '/other-pages/' . strtolower(str_replace(' ', '-', $item['en'])),
                    'ru' => '/other-pages/' . strtolower(str_replace(' ', '-', $item['ru']))
                ],
                'target' => '_self',
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // SHOP Mega Menu Widget
        $shopWidget = Widget::create([
            'title' => [
                'az' => 'Yeni Üfüqlər',
                'en' => 'New Horizons',
                'ru' => 'Новые горизонты'
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
                'az' => '/collections/new-horizons',
                'en' => '/collections/new-horizons',
                'ru' => '/collections/new-horizons'
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);
        // Widget image ekle
        $shopWidget->addMediaFromUrl('https://picsum.photos/400/600')->toMediaCollection('image');
        $headerShop->widgets()->attach($shopWidget->id);

        // HEADER: Dropdown - BLOG
        $headerBlog = Menu::create([
            'parent_id' => null,
            'type' => MenuType::DROPDOWN->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Blog',
                'en' => 'Blog',
                'ru' => 'Блог'
            ],
            'url' => [
                'az' => '/blog',
                'en' => '/blog',
                'ru' => '/blog'
            ],
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // BLOG children
        $blogItems = [
            ['az' => 'Blog V1', 'en' => 'Blog V1', 'ru' => 'Блог V1'],
            ['az' => 'Blog V2', 'en' => 'Blog V2', 'ru' => 'Блог V2'],
            ['az' => 'Blog V3', 'en' => 'Blog V3', 'ru' => 'Блог V3'],
            ['az' => 'Blog Detalı', 'en' => 'Blog Detail', 'ru' => 'Детали блога'],
        ];

        foreach ($blogItems as $index => $item) {
            Menu::create([
                'parent_id' => $headerBlog->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::HEADER->value,
                'title' => [
                    'az' => $item['az'],
                    'en' => $item['en'],
                    'ru' => $item['ru']
                ],
                'url' => [
                    'az' => '/blog/v' . ($index + 1),
                    'en' => '/blog/v' . ($index + 1),
                    'ru' => '/blog/v' . ($index + 1)
                ],
                'target' => '_self',
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // HEADER: Dropdown - PAGES
        $headerPages = Menu::create([
            'parent_id' => null,
            'type' => MenuType::DROPDOWN->value,
            'position' => MenuPosition::HEADER->value,
            'title' => [
                'az' => 'Səhifələr',
                'en' => 'Pages',
                'ru' => 'Страницы'
            ],
            'url' => [
                'az' => '/pages',
                'en' => '/pages',
                'ru' => '/pages'
            ],
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        // PAGES children
        $pagesItems = [
            ['az' => 'Hesabım', 'en' => 'My Account', 'ru' => 'Мой аккаунт'],
            ['az' => 'Giriş / Qeydiyyat', 'en' => 'Login / Register', 'ru' => 'Вход / Регистрация'],
            ['az' => 'Mağaza Yerləşdirmə', 'en' => 'Store Locator', 'ru' => 'Поиск магазина'],
            ['az' => 'Baxış Kitabı', 'en' => 'Lookbook', 'ru' => 'Lookbook'],
            ['az' => 'Tez-tez Verilən Suallar', 'en' => 'Faq', 'ru' => 'Часто задаваемые вопросы'],
            ['az' => 'Şərtlər', 'en' => 'Terms', 'ru' => 'Условия'],
            ['az' => '404 Xəta', 'en' => '404 Error', 'ru' => '404 Ошибка'],
            ['az' => 'Tezliklə', 'en' => 'Coming Soon', 'ru' => 'Скоро'],
        ];

        foreach ($pagesItems as $index => $item) {
            Menu::create([
                'parent_id' => $headerPages->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::HEADER->value,
                'title' => [
                    'az' => $item['az'],
                    'en' => $item['en'],
                    'ru' => $item['ru']
                ],
                'url' => [
                    'az' => '/pages/' . strtolower(str_replace([' ', '/', 'ə'], ['-', '-', 'e'], $item['az'])),
                    'en' => '/pages/' . strtolower(str_replace([' ', '/'], '-', $item['en'])),
                    'ru' => '/pages/' . strtolower(str_replace(' ', '-', $item['ru']))
                ],
                'target' => '_self',
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // HEADER: Normal Link - ABOUT
        $headerAbout = Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::HEADER->value,
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
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 5,
        ]);

        // HEADER: Normal Link - CONTACT
        $headerContact = Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::HEADER->value,
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
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 6,
        ]);

        // ============================================
        // FOOTER MENUS
        // ============================================

        // FOOTER: Company Menu
        $footerCompany = Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::FOOTER->value,
            'title' => [
                'az' => 'Şirkət',
                'en' => 'Company',
                'ru' => 'Компания'
            ],
            'url' => [
                'az' => '#',
                'en' => '#',
                'ru' => '#'
            ],
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Company children
        $companyItems = [
            ['az' => 'Haqqımızda', 'en' => 'About Us', 'ru' => 'О нас'],
            ['az' => 'Karyera', 'en' => 'Careers', 'ru' => 'Карьера'],
            ['az' => 'Tərəfdaşlar', 'en' => 'Affiliates', 'ru' => 'Партнеры'],
            ['az' => 'Blog', 'en' => 'Blog', 'ru' => 'Блог'],
            ['az' => 'Bizimlə əlaqə', 'en' => 'Contact Us', 'ru' => 'Свяжитесь с нами'],
        ];

        foreach ($companyItems as $index => $item) {
            Menu::create([
                'parent_id' => $footerCompany->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::FOOTER->value,
                'title' => [
                    'az' => $item['az'],
                    'en' => $item['en'],
                    'ru' => $item['ru']
                ],
                'url' => [
                    'az' => '/pages/' . strtolower(str_replace([' ', 'ə'], ['-', 'e'], $item['az'])),
                    'en' => '/pages/' . strtolower(str_replace(' ', '-', $item['en'])),
                    'ru' => '/pages/' . strtolower(str_replace(' ', '-', $item['ru']))
                ],
                'target' => '_self',
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // FOOTER: Shop Menu
        $footerShop = Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::FOOTER->value,
            'title' => [
                'az' => 'Mağaza',
                'en' => 'Shop',
                'ru' => 'Магазин'
            ],
            'url' => [
                'az' => '/products',
                'en' => '/products',
                'ru' => '/products'
            ],
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // Shop children
        $shopItems = [
            ['az' => 'Yeni gəlmələr', 'en' => 'New Arrivals', 'ru' => 'Новинки'],
            ['az' => 'Aksesuarlar', 'en' => 'Accessories', 'ru' => 'Аксессуары'],
            ['az' => 'Kişi', 'en' => 'Men', 'ru' => 'Мужчины'],
            ['az' => 'Qadın', 'en' => 'Women', 'ru' => 'Женщины'],
            ['az' => 'Hamısı', 'en' => 'Shop All', 'ru' => 'Все товары'],
        ];

        foreach ($shopItems as $index => $item) {
            Menu::create([
                'parent_id' => $footerShop->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::FOOTER->value,
                'title' => [
                    'az' => $item['az'],
                    'en' => $item['en'],
                    'ru' => $item['ru']
                ],
                'url' => [
                    'az' => '/products?filter=' . strtolower(str_replace([' ', 'ə'], ['-', 'e'], $item['az'])),
                    'en' => '/products?filter=' . strtolower(str_replace(' ', '-', $item['en'])),
                    'ru' => '/products?filter=' . strtolower(str_replace(' ', '-', $item['ru']))
                ],
                'target' => '_self',
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // FOOTER: Help Menu
        $footerHelp = Menu::create([
            'parent_id' => null,
            'type' => MenuType::NORMAL_LINK->value,
            'position' => MenuPosition::FOOTER->value,
            'title' => [
                'az' => 'Kömək',
                'en' => 'Help',
                'ru' => 'Помощь'
            ],
            'url' => [
                'az' => '#',
                'en' => '#',
                'ru' => '#'
            ],
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // Help children
        $helpItems = [
            ['az' => 'Müştəri Xidməti', 'en' => 'Customer Service', 'ru' => 'Служба поддержки'],
            ['az' => 'Hesabım', 'en' => 'My Account', 'ru' => 'Мой аккаунт'],
            ['az' => 'Mağaza tap', 'en' => 'Find a Store', 'ru' => 'Найти магазин'],
            ['az' => 'Hüquqi və Məxfilik', 'en' => 'Legal & Privacy', 'ru' => 'Юридическая информация и конфиденциальность'],
            ['az' => 'Əlaqə', 'en' => 'Contact', 'ru' => 'Контакты'],
            ['az' => 'Hədiyyə Kartı', 'en' => 'Gift Card', 'ru' => 'Подарочная карта'],
        ];

        foreach ($helpItems as $index => $item) {
            Menu::create([
                'parent_id' => $footerHelp->id,
                'type' => MenuType::NORMAL_LINK->value,
                'position' => MenuPosition::FOOTER->value,
                'title' => [
                    'az' => $item['az'],
                    'en' => $item['en'],
                    'ru' => $item['ru']
                ],
                'url' => [
                    'az' => '/pages/' . strtolower(str_replace([' ', '&', 'ə'], ['-', '-', 'e'], $item['az'])),
                    'en' => '/pages/' . strtolower(str_replace([' ', '&'], '-', $item['en'])),
                    'ru' => '/pages/' . strtolower(str_replace([' ', '&'], '-', $item['ru']))
                ],
                'target' => '_self',
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
}

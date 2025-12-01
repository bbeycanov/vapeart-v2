<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Product, Brand, Category, Tag, Menu};
use App\Enums\MenuPosition;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $brand = Brand::first();
        $jackets = Category::where('slug', 'jackets')->first();
        $tags = Tag::pluck('id')->toArray();

        // Featured menüleri çek
        $bestSellers = Menu::where('position', MenuPosition::FEATURED->value)
            ->where('title->en', 'Best Sellers')
            ->first();
        
        $mostPopular = Menu::where('position', MenuPosition::FEATURED->value)
            ->where('title->en', 'Most Popular')
            ->first();
        
        $top20 = Menu::where('position', MenuPosition::FEATURED->value)
            ->where('title->en', 'Top 20')
            ->first();
        
        $bestRated = Menu::where('position', MenuPosition::FEATURED->value)
            ->where('title->en', 'Best Rated')
            ->first();

        // Best Sellers Products
        $products = [
            [
                'slug' => 'lightweight-puffer-jacket-with-hood',
                'sku' => 'SKU-1001',
                'name' => [
                    'en' => 'Lightweight Puffer Jacket With a Hood',
                    'az' => 'Kapüşonlu Yüngül Puffer Kurtka',
                    'ru' => 'Легкая пуховая куртка с капюшоном',
                ],
                'short_description' => [
                    'en' => 'Warm, durable and stylish jacket for winter.',
                    'az' => 'İsti, davamlı və şık kurtka qış üçün.',
                    'ru' => 'Теплая, прочная и стильная куртка для зимы.',
                ],
                'description' => [
                    'en' => '<p>This puffer jacket provides warmth with lightweight insulation.</p>',
                    'az' => '<p>Bu puffer kurtka yüngül izolyasiya ilə sizi isti saxlayacaq.</p>',
                    'ru' => '<p>Эта пуховая куртка обеспечивает тепло с легкой изоляцией.</p>',
                ],
                'meta_title' => ['en' => 'UOMO Puffer Jacket', 'az' => 'UOMO Puffer Kurtka', 'ru' => 'UOMO Пуховая куртка'],
                'meta_description' => ['en' => 'Premium jacket for all seasons.', 'az' => 'Bütün fəsillər üçün premium kurtka.', 'ru' => 'Премиум куртка на все сезоны.'],
                'price' => 449.00,
                'compare_at_price' => 499.00,
                'currency' => 'AZN',
                'stock_qty' => 15,
                'is_featured' => true,
                'sort_order' => 1,
                'menu' => $bestSellers,
            ],
            [
                'slug' => 'classic-denim-jacket',
                'sku' => 'SKU-1002',
                'name' => [
                    'en' => 'Classic Denim Jacket',
                    'az' => 'Klassik Denim Kurtka',
                    'ru' => 'Классическая джинсовая куртка',
                ],
                'short_description' => [
                    'en' => 'Timeless denim jacket for any occasion.',
                    'az' => 'Hər hansı bir hadisə üçün zamansız denim kurtka.',
                    'ru' => 'Вечная джинсовая куртка на любой случай.',
                ],
                'description' => [
                    'en' => '<p>A classic denim jacket that never goes out of style.</p>',
                    'az' => '<p>Klassik denim kurtka heç vaxt modadan düşmür.</p>',
                    'ru' => '<p>Классическая джинсовая куртка, которая никогда не выходит из моды.</p>',
                ],
                'meta_title' => ['en' => 'Denim Jacket', 'az' => 'Denim Kurtka', 'ru' => 'Джинсовая куртка'],
                'meta_description' => ['en' => 'Timeless classic denim jacket.', 'az' => 'Zamansız klassik denim kurtka.', 'ru' => 'Вечная классическая джинсовая куртка.'],
                'price' => 299.00,
                'compare_at_price' => 349.00,
                'currency' => 'AZN',
                'stock_qty' => 20,
                'is_featured' => true,
                'sort_order' => 2,
                'menu' => $bestSellers,
            ],
            [
                'slug' => 'leather-bomber-jacket',
                'sku' => 'SKU-1003',
                'name' => [
                    'en' => 'Leather Bomber Jacket',
                    'az' => 'Dəri Bomber Kurtka',
                    'ru' => 'Кожаная куртка-бомбер',
                ],
                'short_description' => [
                    'en' => 'Premium leather bomber jacket.',
                    'az' => 'Premium dəri bomber kurtka.',
                    'ru' => 'Премиум кожаная куртка-бомбер.',
                ],
                'description' => [
                    'en' => '<p>High-quality leather bomber jacket for the modern man.</p>',
                    'az' => '<p>Müasir kişi üçün yüksək keyfiyyətli dəri bomber kurtka.</p>',
                    'ru' => '<p>Высококачественная кожаная куртка-бомбер для современного мужчины.</p>',
                ],
                'meta_title' => ['en' => 'Leather Bomber', 'az' => 'Dəri Bomber', 'ru' => 'Кожаная бомбер'],
                'meta_description' => ['en' => 'Premium leather bomber jacket.', 'az' => 'Premium dəri bomber kurtka.', 'ru' => 'Премиум кожаная куртка-бомбер.'],
                'price' => 899.00,
                'compare_at_price' => 999.00,
                'currency' => 'AZN',
                'stock_qty' => 10,
                'is_featured' => true,
                'sort_order' => 1,
                'menu' => $mostPopular,
            ],
            [
                'slug' => 'windbreaker-jacket',
                'sku' => 'SKU-1004',
                'name' => [
                    'en' => 'Windbreaker Jacket',
                    'az' => 'Külək Kəsən Kurtka',
                    'ru' => 'Ветровка',
                ],
                'short_description' => [
                    'en' => 'Lightweight windbreaker for outdoor activities.',
                    'az' => 'Açıq hava fəaliyyətləri üçün yüngül külək kəsən.',
                    'ru' => 'Легкая ветровка для активного отдыха.',
                ],
                'description' => [
                    'en' => '<p>Perfect windbreaker for running and outdoor sports.</p>',
                    'az' => '<p>Qaçış və açıq hava idmanları üçün mükəmməl külək kəsən.</p>',
                    'ru' => '<p>Идеальная ветровка для бега и активного отдыха.</p>',
                ],
                'meta_title' => ['en' => 'Windbreaker', 'az' => 'Külək Kəsən', 'ru' => 'Ветровка'],
                'meta_description' => ['en' => 'Lightweight windbreaker jacket.', 'az' => 'Yüngül külək kəsən kurtka.', 'ru' => 'Легкая ветровка.'],
                'price' => 199.00,
                'compare_at_price' => 249.00,
                'currency' => 'AZN',
                'stock_qty' => 25,
                'is_featured' => true,
                'sort_order' => 2,
                'menu' => $mostPopular,
            ],
            [
                'slug' => 'wool-coat',
                'sku' => 'SKU-1005',
                'name' => [
                    'en' => 'Wool Coat',
                    'az' => 'Yun Palto',
                    'ru' => 'Шерстяное пальто',
                ],
                'short_description' => [
                    'en' => 'Elegant wool coat for formal occasions.',
                    'az' => 'Rəsmi tədbirlər üçün zərif yun palto.',
                    'ru' => 'Элегантное шерстяное пальто для официальных мероприятий.',
                ],
                'description' => [
                    'en' => '<p>Sophisticated wool coat perfect for business meetings.</p>',
                    'az' => '<p>Biznes görüşləri üçün mükəmməl mürəkkəb yun palto.</p>',
                    'ru' => '<p>Изысканное шерстяное пальто, идеальное для деловых встреч.</p>',
                ],
                'meta_title' => ['en' => 'Wool Coat', 'az' => 'Yun Palto', 'ru' => 'Шерстяное пальто'],
                'meta_description' => ['en' => 'Elegant wool coat.', 'az' => 'Zərif yun palto.', 'ru' => 'Элегантное шерстяное пальто.'],
                'price' => 749.00,
                'compare_at_price' => 849.00,
                'currency' => 'AZN',
                'stock_qty' => 12,
                'is_featured' => true,
                'sort_order' => 1,
                'menu' => $top20,
            ],
            [
                'slug' => 'sports-hoodie',
                'sku' => 'SKU-1006',
                'name' => [
                    'en' => 'Sports Hoodie',
                    'az' => 'İdman Sviter',
                    'ru' => 'Спортивная толстовка',
                ],
                'short_description' => [
                    'en' => 'Comfortable sports hoodie for training.',
                    'az' => 'Məşq üçün rahat idman sviter.',
                    'ru' => 'Удобная спортивная толстовка для тренировок.',
                ],
                'description' => [
                    'en' => '<p>Breathable and comfortable hoodie for all sports activities.</p>',
                    'az' => '<p>Bütün idman fəaliyyətləri üçün nəfəs alan və rahat sviter.</p>',
                    'ru' => '<p>Дышащая и удобная толстовка для всех видов спорта.</p>',
                ],
                'meta_title' => ['en' => 'Sports Hoodie', 'az' => 'İdman Sviter', 'ru' => 'Спортивная толстовка'],
                'meta_description' => ['en' => 'Comfortable sports hoodie.', 'az' => 'Rahat idman sviter.', 'ru' => 'Удобная спортивная толстовка.'],
                'price' => 149.00,
                'compare_at_price' => 179.00,
                'currency' => 'AZN',
                'stock_qty' => 30,
                'is_featured' => true,
                'sort_order' => 2,
                'menu' => $top20,
            ],
            [
                'slug' => 'premium-blazer',
                'sku' => 'SKU-1007',
                'name' => [
                    'en' => 'Premium Blazer',
                    'az' => 'Premium Blazer',
                    'ru' => 'Премиум блейзер',
                ],
                'short_description' => [
                    'en' => 'Elegant blazer for professional settings.',
                    'az' => 'Peşəkar mühit üçün zərif blazer.',
                    'ru' => 'Элегантный блейзер для профессиональной обстановки.',
                ],
                'description' => [
                    'en' => '<p>Premium quality blazer for business professionals.</p>',
                    'az' => '<p>Biznes peşəkarları üçün premium keyfiyyətli blazer.</p>',
                    'ru' => '<p>Блейзер премиум качества для бизнес-профессионалов.</p>',
                ],
                'meta_title' => ['en' => 'Premium Blazer', 'az' => 'Premium Blazer', 'ru' => 'Премиум блейзер'],
                'meta_description' => ['en' => 'Elegant premium blazer.', 'az' => 'Zərif premium blazer.', 'ru' => 'Элегантный премиум блейзер.'],
                'price' => 599.00,
                'compare_at_price' => 699.00,
                'currency' => 'AZN',
                'stock_qty' => 18,
                'is_featured' => true,
                'sort_order' => 1,
                'menu' => $bestRated,
            ],
            [
                'slug' => 'casual-cardigan',
                'sku' => 'SKU-1008',
                'name' => [
                    'en' => 'Casual Cardigan',
                    'az' => 'Gündəlik Kardiqan',
                    'ru' => 'Повседневный кардиган',
                ],
                'short_description' => [
                    'en' => 'Comfortable cardigan for everyday wear.',
                    'az' => 'Gündəlik geyim üçün rahat kardiqan.',
                    'ru' => 'Удобный кардиган для повседневной носки.',
                ],
                'description' => [
                    'en' => '<p>Soft and comfortable cardigan for casual occasions.</p>',
                    'az' => '<p>Gündəlik hadisələr üçün yumşaq və rahat kardiqan.</p>',
                    'ru' => '<p>Мягкий и удобный кардиган для повседневных случаев.</p>',
                ],
                'meta_title' => ['en' => 'Casual Cardigan', 'az' => 'Gündəlik Kardiqan', 'ru' => 'Повседневный кардиган'],
                'meta_description' => ['en' => 'Comfortable casual cardigan.', 'az' => 'Rahat gündəlik kardiqan.', 'ru' => 'Удобный повседневный кардиган.'],
                'price' => 249.00,
                'compare_at_price' => 299.00,
                'currency' => 'AZN',
                'stock_qty' => 22,
                'is_featured' => true,
                'sort_order' => 2,
                'menu' => $bestRated,
            ],
        ];

        // Product images mapping - each product gets a main image and gallery images
        $productImages = [
            'lightweight-puffer-jacket-with-hood' => [
                'thumbnail' => 'product_0.jpg',
                'gallery' => ['product_0-1.jpg', 'product_0-2.jpg', 'product_0-3.jpg']
            ],
            'classic-denim-jacket' => [
                'thumbnail' => 'product_1.jpg',
                'gallery' => ['product_1-1.jpg', 'product_2.jpg']
            ],
            'leather-bomber-jacket' => [
                'thumbnail' => 'product_2.jpg',
                'gallery' => ['product_2-1.jpg', 'product_3.jpg']
            ],
            'windbreaker-jacket' => [
                'thumbnail' => 'product_3.jpg',
                'gallery' => ['product_3-1.jpg', 'product_4.jpg']
            ],
            'wool-coat' => [
                'thumbnail' => 'product_4.jpg',
                'gallery' => ['product_4-1.jpg', 'product_5.jpg']
            ],
            'sports-hoodie' => [
                'thumbnail' => 'product_5.jpg',
                'gallery' => ['product_5-1.jpg', 'product_6.jpg']
            ],
            'premium-blazer' => [
                'thumbnail' => 'product_6.jpg',
                'gallery' => ['product_6-1.jpg', 'product_7.jpg']
            ],
            'casual-cardigan' => [
                'thumbnail' => 'product_7.jpg',
                'gallery' => ['product_7-1.jpg', 'product_8.jpg']
            ],
        ];

        // Mevcut ürünleri oluştur
        foreach ($products as $index => $productData) {
            $menu = $productData['menu'];
            unset($productData['menu']);

            $product = Product::updateOrCreate(
                ['slug' => $productData['slug']],
                array_merge($productData, [
                    'brand_id' => $brand?->id,
                    'is_track_stock' => true,
                    'is_active' => true,
                ])
            );

            // Attach relationships
            if ($jackets) $product->categories()->syncWithoutDetaching([$jackets->id]);
            if ($tags) $product->tags()->sync($tags);
            if ($menu) $product->menus()->sync([$menu->id]);

            // Add images using Spatie Media Library
            $images = $productImages[$productData['slug']] ?? null;
            if ($images) {
                $sourcePath = public_path('storefront/images/products/');
                $storagePath = storage_path('app/public/products/');
                
                // Create storage directory if it doesn't exist
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }
                
                // Add thumbnail (single file collection)
                if (isset($images['thumbnail']) && file_exists($sourcePath . $images['thumbnail'])) {
                    if (!$product->hasMedia('thumbnail')) {
                        // Copy to storage
                        $destinationFile = $storagePath . $images['thumbnail'];
                        copy($sourcePath . $images['thumbnail'], $destinationFile);
                        
                        // Add to media library
                        $product->addMedia($destinationFile)
                            ->toMediaCollection('thumbnail');
                    }
                }
                
                // Add gallery images (multiple images collection)
                if (isset($images['gallery']) && is_array($images['gallery'])) {
                    // Clear existing images if any
                    $product->clearMediaCollection('images');
                    
                    foreach ($images['gallery'] as $imageFile) {
                        $sourceFile = $sourcePath . $imageFile;
                        if (file_exists($sourceFile)) {
                            // Copy to storage
                            $destinationFile = $storagePath . $imageFile;
                            copy($sourceFile, $destinationFile);
                            
                            // Add to media library
                            $product->addMedia($destinationFile)
                                ->toMediaCollection('images');
                        }
                    }
                }
            }
        }

        // 100 Adet Rastgele Ürün Oluştur ve Jackets Kategorisine Bağla
        if ($jackets) {
            $randomProducts = Product::factory()->count(100)->create();
            
            foreach ($randomProducts as $randomProduct) {
                $randomProduct->categories()->syncWithoutDetaching([$jackets->id]);
                
                // Rastgele resim ekle (mevcut resimlerden)
                $randomImageIndex = rand(0, 7);
                $sourceImage = 'product_' . $randomImageIndex . '.jpg';
                $sourcePath = public_path('storefront/images/products/' . $sourceImage);
                
                if (file_exists($sourcePath)) {
                    $storagePath = storage_path('app/public/products/');
                    if (!file_exists($storagePath)) {
                        mkdir($storagePath, 0755, true);
                    }
                    
                    $destinationFile = $storagePath . 'random_' . $randomProduct->id . '.jpg';
                    copy($sourcePath, $destinationFile);
                    
                    $randomProduct->addMedia($destinationFile)
                        ->toMediaCollection('thumbnail');
                }
            }
        }
    }
}

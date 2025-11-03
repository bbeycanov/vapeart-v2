<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'slug' => 'uomo',
                'name' => [
                    'en' => 'UOMO',
                    'az' => 'UOMO',
                    'ru' => 'UOMO'
                ],
                'description' => [
                    'en' => 'Premium fashion brand',
                    'az' => 'Premium geyim markası',
                    'ru' => 'Премиальный бренд моды'
                ],
                'meta_title' => [
                    'en' => 'UOMO - Premium Fashion',
                    'az' => 'UOMO - Premium Geyim',
                    'ru' => 'UOMO - Премиальная мода'
                ],
                'meta_description' => [
                    'en' => 'Discover the latest trends with UOMO.',
                    'az' => 'UOMO ilə ən son trendləri kəşf edin.',
                    'ru' => 'Откройте для себя последние тенденции с UOMO.'
                ],
                'social_links' => [
                    'facebook' => 'https://facebook.com/uomo',
                    'instagram' => 'https://instagram.com/uomo',
                    'twitter' => 'https://twitter.com/uomo',
                ],
                'website' => 'https://uomo.example.com',
                'is_active' => true,
            ],
            [
                'slug' => 'nike',
                'name' => [
                    'en' => 'Nike',
                    'az' => 'Nike',
                    'ru' => 'Nike'
                ],
                'description' => [
                    'en' => 'Sportswear and sneakers',
                    'az' => 'İdman geyimləri və ayaqqabılar',
                    'ru' => 'Спортивная одежда и кроссовки'
                ],
                'meta_title' => [
                    'en' => 'Nike - Just Do It',
                    'az' => 'Nike - Sadəcə Et',
                    'ru' => 'Nike - Просто сделай это'
                ],
                'meta_description' => [
                    'en' => 'Explore Nike\'s latest collection.',
                    'az' => 'Nike-in ən son kolleksiyasını kəşf edin.',
                    'ru' => 'Исследуйте последнюю коллекцию Nike.'
                ],
                'social_links' => [
                    'facebook' => 'https://facebook.com/nike',
                    'instagram' => 'https://instagram.com/nike',
                    'twitter' => 'https://twitter.com/nike',
                ],
                'website' => 'https://nike.com',
                'is_active' => true,
            ],
        ];

        foreach ($brands as $data) {
            Brand::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}

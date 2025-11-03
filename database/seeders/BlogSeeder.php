<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Services\Contracts\BlogServiceInterface;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        /** @var BlogServiceInterface $svc */
        $svc = app(BlogServiceInterface::class);

        $now = Carbon::now();

        // Blog #1
        $svc->create([
            'slug' => 'how-to-use-vape-safely',
            'title' => [
                'az' => 'Elektron siqareti təhlükəsiz istifadə etməyin yolları',
                'en' => 'How to Use Vape Safely',
            ],
            'excerpt' => [
                'az' => 'Sağlamlıq üçün riskləri minimuma endirmək üçün ipucları.',
                'en' => 'Tips to minimize health risks while vaping.',
            ],
            'body' => [
                'az' => '<p>Elektron siqaretin düzgün istifadəsi üçün bəzi qaydalara əməl etmək lazımdır...</p>',
                'en' => '<p>To use your vape safely, always keep it clean and store the e-liquid properly...</p>',
            ],
            'meta_title' => [
                'az' => 'Elektron siqaretin təhlükəsiz istifadəsi',
                'en' => 'Vaping Safety Guide',
            ],
            'meta_description' => [
                'az' => 'Bu məqalədə elektron siqaretin təhlükəsiz istifadəsi üçün əsas qaydaları öyrənəcəksiniz.',
                'en' => 'Learn key safety principles for using vape devices.',
            ],
            'author_name' => 'Admin',
            'reading_time' => 4,
            'published_at' => $now->subDays(10),
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Blog #2
        $svc->create([
            'slug' => 'latest-vape-flavors-2025',
            'title' => [
                'az' => '2025-ci ilin yeni vape dadları',
                'en' => 'Latest Vape Flavors of 2025',
            ],
            'excerpt' => [
                'az' => 'Bu il bazara çıxan ən məşhur dadlar.',
                'en' => 'A quick overview of the trending flavors this year.',
            ],
            'body' => [
                'az' => '<p>Yeni dadlar arasında tropik meyvələr, mentol və desert aromaları xüsusilə sevilir...</p>',
                'en' => '<p>This year’s vape trends include tropical fruits, menthol, and dessert-inspired blends...</p>',
            ],
            'meta_title' => [
                'az' => '2025 vape dad trendi',
                'en' => 'Top Vape Flavors 2025',
            ],
            'meta_description' => [
                'az' => 'Ən son vape dad trendini kəşf edin.',
                'en' => 'Discover the most popular vape flavors of 2025.',
            ],
            'author_name' => 'VapeArt Team',
            'reading_time' => 3,
            'published_at' => $now->subDays(5),
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // Blog #3 (draft)
        $svc->create([
            'slug' => 'vape-maintenance-tips',
            'title' => [
                'az' => 'Vape cihazınızın qulluq qaydaları',
                'en' => 'Vape Maintenance Tips',
            ],
            'excerpt' => [
                'az' => 'Cihazınızın ömrünü uzatmaq üçün təlimatlar.',
                'en' => 'How to extend your device lifespan with proper care.',
            ],
            'body' => [
                'az' => '<p>Hər istifadədən sonra cihazınızı təmizləmək çox vacibdir...</p>',
                'en' => '<p>Always clean your vape tank after each use to prevent residue buildup...</p>',
            ],
            'author_name' => 'Admin',
            'reading_time' => 5,
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\Contracts\PageServiceInterface;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $svc = app(PageServiceInterface::class);

        $svc->create([
            'slug' => 'about',
            'template' => 'default',
            'title' => ['az'=>'Haqqımızda','en'=>'About Us'],
            'excerpt' => ['az'=>'Qısa təsvir','en'=>'Short description'],
            'body' => ['az'=>'<p>Biz kimik...</p>','en'=>'<p>Who we are...</p>'],
            'meta_title' => ['az'=>'Haqqımızda - MySite','en'=>'About Us - MySite'],
            'meta_description' => ['az'=>'Haqqımızda səhifəsi','en'=>'About page'],
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}

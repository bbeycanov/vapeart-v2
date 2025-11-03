<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['slug' => 'bomber', 'name' => ['en' => 'Bomber', 'az' => 'Bomber', 'ru' => 'Бомбер']],
            ['slug' => 'denim', 'name' => ['en' => 'Denim', 'az' => 'Cins', 'ru' => 'Деним']],
            ['slug' => 'black', 'name' => ['en' => 'Black', 'az' => 'Qara', 'ru' => 'Черный']],
            ['slug' => 'red', 'name' => ['en' => 'Red', 'az' => 'Qırmızı', 'ru' => 'Красный']],
            ['slug' => 'blue', 'name' => ['en' => 'Blue', 'az' => 'Mavi', 'ru' => 'Синий']],
            ['slug' => 'formal', 'name' => ['en' => 'Formal', 'az' => 'Rəsmi', 'ru' => 'Формальный']],
            ['slug' => 'leather', 'name' => ['en' => 'Leather', 'az' => 'Dəri', 'ru' => 'Кожа']],
            ['slug' => 'casual', 'name' => ['en' => 'Casual', 'az' => 'Gündəlik', 'ru' => 'Повседневный']],
        ];

        foreach ($tags as $data) {
            Tag::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}

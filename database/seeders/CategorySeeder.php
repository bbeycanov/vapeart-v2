<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $root = Category::updateOrCreate(
            ['slug' => 'clothing'],
            [
                'name' => ['en' => 'Clothing', 'az' => 'Geyim', 'ru' => 'Одежда'],
                'description' => ['en' => 'All types of clothes', 'az' => 'Bütün geyim növləri'],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'jackets'],
            [
                'parent_id' => $root->id,
                'name' => ['en' => 'Jackets', 'az' => 'Kurtkalar', 'ru' => 'Куртки'],
                'description' => ['en' => 'Warm and stylish jackets', 'az' => 'İsti və şık kurtkalar'],
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        Category::updateOrCreate(
            ['slug' => 't-shirts'],
            [
                'parent_id' => $root->id,
                'name' => ['en' => 'T-Shirts', 'az' => 'Futbolkalar', 'ru' => 'Футболки'],
                'description' => ['en' => 'Comfortable t-shirts', 'az' => 'Rahat futbolkalar'],
                'is_active' => true,
                'sort_order' => 3,
            ]
        );
    }
}

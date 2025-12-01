<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        $price = $this->faker->randomFloat(2, 10, 1000);
        
        return [
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory(),
            'sku' => $this->faker->unique()->ean8(),
            'slug' => Str::slug($name),
            'name' => [
                'en' => $name,
                'az' => $name . ' (AZ)',
                'ru' => $name . ' (RU)',
            ],
            'short_description' => [
                'en' => $this->faker->sentence(),
                'az' => $this->faker->sentence() . ' (AZ)',
                'ru' => $this->faker->sentence() . ' (RU)',
            ],
            'description' => [
                'en' => $this->faker->paragraph(),
                'az' => $this->faker->paragraph() . ' (AZ)',
                'ru' => $this->faker->paragraph() . ' (RU)',
            ],
            'meta_title' => [
                'en' => $name,
                'az' => $name . ' (AZ)',
                'ru' => $name . ' (RU)',
            ],
            'meta_description' => [
                'en' => $this->faker->sentence(),
                'az' => $this->faker->sentence() . ' (AZ)',
                'ru' => $this->faker->sentence() . ' (RU)',
            ],
            'price' => $price,
            'compare_at_price' => $this->faker->boolean(30) ? $price * 1.2 : null,
            'currency' => 'AZN',
            'stock_qty' => $this->faker->numberBetween(0, 100),
            'is_track_stock' => true,
            'is_active' => true,
            'is_featured' => $this->faker->boolean(20),
            'is_new' => $this->faker->boolean(10),
            'is_hot' => $this->faker->boolean(5),
            'reviews_count' => 0,
            'rating_avg' => 0,
        ];
    }
}


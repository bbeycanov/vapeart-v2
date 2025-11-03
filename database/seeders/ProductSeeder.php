<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Product, Brand, Category, Tag};

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $brand = Brand::first();
        $jackets = Category::where('slug', 'jackets')->first();
        $tags = Tag::pluck('id')->toArray();

        $product = Product::updateOrCreate(
            ['slug' => 'lightweight-puffer-jacket-with-hood'],
            [
                'brand_id' => $brand?->id,
                'sku' => 'SKU-1001',
                'name' => [
                    'en' => 'Lightweight Puffer Jacket With a Hood',
                    'az' => 'Kapüşonlu Yüngül Puffer Kurtka',
                ],
                'short_description' => [
                    'en' => 'Warm, durable and stylish jacket for winter.',
                    'az' => 'İsti, davamlı və şık kurtka qış üçün.',
                ],
                'description' => [
                    'en' => '<p>This puffer jacket provides warmth with lightweight insulation.</p>',
                    'az' => '<p>Bu puffer kurtka yüngül izolyasiya ilə sizi isti saxlayacaq.</p>',
                ],
                'meta_title' => ['en' => 'UOMO Puffer Jacket', 'az' => 'UOMO Puffer Kurtka'],
                'meta_description' => ['en' => 'Premium jacket for all seasons.', 'az' => 'Bütün fəsillər üçün premium kurtka.'],
                'price' => 449.00,
                'compare_at_price' => 499.00,
                'currency' => 'USD',
                'stock_qty' => 15,
                'is_track_stock' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // Attach relationships
        if ($jackets) $product->categories()->sync([$jackets->id]);
        if ($tags) $product->tags()->sync($tags);
    }
}

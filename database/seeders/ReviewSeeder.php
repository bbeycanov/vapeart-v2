<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Review, Product};

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::where('slug', 'lightweight-puffer-jacket-with-hood')->first();

        if (!$product) return;

        $reviews = [
            [
                'reviewable_type' => Product::class,
                'reviewable_id' => $product->id,
                'rating' => 5,
                'title' => 'Amazing Quality!',
                'body' => 'Very warm and comfortable. Highly recommended!',
                'author_name' => 'John Doe',
                'author_email' => 'john@example.com',
                'status' => 1,
                'published_at' => now()->subDays(3),
            ],
            [
                'reviewable_type' => Product::class,
                'reviewable_id' => $product->id,
                'rating' => 4,
                'title' => 'Stylish but a bit pricey',
                'body' => 'Looks great but could be cheaper. Still love it!',
                'author_name' => 'Jane Smith',
                'author_email' => 'jane@example.com',
                'status' => 1,
                'published_at' => now()->subDay(),
            ],
        ];

        foreach ($reviews as $data) {
            Review::updateOrCreate([
                'reviewable_type' => $data['reviewable_type'],
                'reviewable_id' => $data['reviewable_id'],
                'author_email' => $data['author_email']
            ], $data);
        }

        // update aggregate stats
        $stat = $product->reviews()->where('status', 1)
            ->selectRaw('count(*) as c, avg(rating) as r')->first();

        $product->update([
            'reviews_count' => (int)($stat->c ?? 0),
            'rating_avg' => round((float)($stat->r ?? 0), 2),
        ]);
    }
}

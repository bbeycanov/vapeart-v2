<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titleEn = fake()->sentence(rand(4, 8));
        $titleAz = fake('az_AZ')->sentence(rand(4, 8));
        $titleRu = fake('ru_RU')->sentence(rand(4, 8));

        $excerptEn = fake()->paragraph(rand(2, 4));
        $excerptAz = fake('az_AZ')->paragraph(rand(2, 4));
        $excerptRu = fake('ru_RU')->paragraph(rand(2, 4));

        $bodyEn = '<p>' . implode('</p><p>', fake()->paragraphs(rand(5, 10))) . '</p>';
        $bodyAz = '<p>' . implode('</p><p>', fake('az_AZ')->paragraphs(rand(5, 10))) . '</p>';
        $bodyRu = '<p>' . implode('</p><p>', fake('ru_RU')->paragraphs(rand(5, 10))) . '</p>';

        $slug = Str::slug($titleEn);

        return [
            'slug' => $slug,
            'title' => [
                'en' => $titleEn,
                'az' => $titleAz,
                'ru' => $titleRu,
            ],
            'excerpt' => [
                'en' => $excerptEn,
                'az' => $excerptAz,
                'ru' => $excerptRu,
            ],
            'body' => [
                'en' => $bodyEn,
                'az' => $bodyAz,
                'ru' => $bodyRu,
            ],
            'meta_title' => [
                'en' => $titleEn,
                'az' => $titleAz,
                'ru' => $titleRu,
            ],
            'meta_description' => [
                'en' => $excerptEn,
                'az' => $excerptAz,
                'ru' => $excerptRu,
            ],
            'author_name' => fake()->name(),
            'reading_time' => rand(3, 15),
            'status' => 1,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    /**
     * Indicate that the blog should be published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 1,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the blog should be unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 0,
            'published_at' => null,
        ]);
    }
}


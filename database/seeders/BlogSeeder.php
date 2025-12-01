<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $blogImages = [
            'blog-1.jpg', 'blog-2.jpg', 'blog-3.jpg', 'blog-4.jpg', 
            'blog-5.jpg', 'blog-6.jpg', 'blog-7.jpg', 'blog-8.jpg',
            'blog-9.jpg', 'blog-10.jpg', 'blog-11.jpg', 'blog-12.jpg'
        ];

        $blogs = [
            [
                'slug' => 'woman-with-good-shoes-is-never-be-ugly-place',
                'title' => [
                    'az' => 'Yaxşı ayaqqabılı qadın heç vaxt çirkin yerdə olmaz',
                    'en' => 'Woman with good shoes is never be ugly place',
                    'ru' => 'Женщина в хорошей обуви никогда не будет в плохом месте'
                ],
                'excerpt' => [
                    'az' => 'Midst one brought greater also morning green saying had good. Open stars day let over gathered, grass face one every light of under.',
                    'en' => 'Midst one brought greater also morning green saying had good. Open stars day let over gathered, grass face one every light of under.',
                    'ru' => 'Среди всего принесенного больше также утреннее зеленое высказывание было хорошим. Открытые звезды день пусть соберутся, трава лицо каждое свет под.'
                ],
                'body' => [
                    'az' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sapien dignissim a elementum. Sociis metus, hendrerit mauris id in. Quis sit sit ultrices tincidunt euismod luctus diam. Turpis sodales orci etiam phasellus lacus id leo.</p><p>Amet turpis nunc, nulla massa est viverra interdum. Praesent auctor nulla morbi non posuere mattis. Arcu eu id maecenas cras. Eget fames tincidunt leo, sed vitae, pretium interdum.</p>',
                    'en' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sapien dignissim a elementum. Sociis metus, hendrerit mauris id in. Quis sit sit ultrices tincidunt euismod luctus diam. Turpis sodales orci etiam phasellus lacus id leo.</p><p>Amet turpis nunc, nulla massa est viverra interdum. Praesent auctor nulla morbi non posuere mattis. Arcu eu id maecenas cras. Eget fames tincidunt leo, sed vitae, pretium interdum.</p>',
                    'ru' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sapien dignissim a elementum. Sociis metus, hendrerit mauris id in. Quis sit sit ultrices tincidunt euismod luctus diam. Turpis sodales orci etiam phasellus lacus id leo.</p><p>Amet turpis nunc, nulla massa est viverra interdum. Praesent auctor nulla morbi non posuere mattis. Arcu eu id maecenas cras. Eget fames tincidunt leo, sed vitae, pretium interdum.</p>'
                ],
                'author_name' => 'Admin',
                'reading_time' => 5,
                'status' => 1,
                'published_at' => $now->subDays(10),
                'is_active' => true,
                'sort_order' => 1,
                'image' => 'blog-1.jpg'
            ],
            [
                'slug' => 'what-freud-can-teach-us-about-furniture',
                'title' => [
                    'az' => 'Freud bizə mebel haqqında nə öyrədə bilər',
                    'en' => 'What Freud Can Teach Us About Furniture',
                    'ru' => 'Чему Фрейд может научить нас о мебели'
                ],
                'excerpt' => [
                    'az' => 'Midst one brought greater also morning green saying had good. Open stars day let over gathered, grass face one every light of under.',
                    'en' => 'Midst one brought greater also morning green saying had good. Open stars day let over gathered, grass face one every light of under.',
                    'ru' => 'Среди всего принесенного больше также утреннее зеленое высказывание было хорошим.'
                ],
                'body' => [
                    'az' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sapien dignissim a elementum.</p>',
                    'en' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sapien dignissim a elementum.</p>',
                    'ru' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sapien dignissim a elementum.</p>'
                ],
                'author_name' => 'Admin',
                'reading_time' => 4,
                'status' => 1,
                'published_at' => $now->subDays(8),
                'is_active' => true,
                'sort_order' => 2,
                'image' => 'blog-2.jpg'
            ],
            [
                'slug' => 'habitant-morbi-tristique-senectus',
                'title' => [
                    'az' => 'Habitant morbi tristique senectus',
                    'en' => 'Habitant morbi tristique senectus',
                    'ru' => 'Habitant morbi tristique senectus'
                ],
                'excerpt' => [
                    'az' => 'Midst one brought greater also morning green saying had good. Open stars day let over gathered, grass face one every light of under.',
                    'en' => 'Midst one brought greater also morning green saying had good. Open stars day let over gathered, grass face one every light of under.',
                    'ru' => 'Среди всего принесенного больше также утреннее зеленое высказывание было хорошим.'
                ],
                'body' => [
                    'az' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                    'en' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                    'ru' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>'
                ],
                'author_name' => 'Admin',
                'reading_time' => 3,
                'status' => 1,
                'published_at' => $now->subDays(5),
                'is_active' => true,
                'sort_order' => 3,
                'image' => 'blog-3.jpg'
            ],
            [
                'slug' => 'heaven-upon-heaven-moveth-every-have',
                'title' => [
                    'az' => 'Cənnət üzərində cənnət hər şeyi hərəkətə gətirir',
                    'en' => 'Heaven upon heaven moveth every have',
                    'ru' => 'Небо над небом движет все'
                ],
                'excerpt' => [
                    'az' => 'Midst one brought greater also morning green saying had good.',
                    'en' => 'Midst one brought greater also morning green saying had good.',
                    'ru' => 'Среди всего принесенного больше также утреннее зеленое высказывание было хорошим.'
                ],
                'body' => [
                    'az' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                    'en' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                    'ru' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>'
                ],
                'author_name' => 'Admin',
                'reading_time' => 6,
                'status' => 1,
                'published_at' => $now->subDays(3),
                'is_active' => true,
                'sort_order' => 4,
                'image' => 'blog-4.jpg'
            ],
            [
                'slug' => 'tree-doesnt-good-void-waters-without-created',
                'title' => [
                    'az' => 'Ağac yaxşı deyil, boşluq, su yaradılmadan',
                    'en' => 'Tree doesn\'t good void, waters without created',
                    'ru' => 'Дерево не хорошо, пустота, воды без создания'
                ],
                'excerpt' => [
                    'az' => 'Midst one brought greater also morning green saying had good.',
                    'en' => 'Midst one brought greater also morning green saying had good.',
                    'ru' => 'Среди всего принесенного больше также утреннее зеленое высказывание было хорошим.'
                ],
                'body' => [
                    'az' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                    'en' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                    'ru' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>'
                ],
                'author_name' => 'Admin',
                'reading_time' => 4,
                'status' => 1,
                'published_at' => $now->subDays(1),
                'is_active' => true,
                'sort_order' => 5,
                'image' => 'blog-5.jpg'
            ],
            [
                'slug' => 'given-set-was-without-from-god-divide-rule-hath',
                'title' => [
                    'az' => 'Verilmiş dəst Allahdan olmadan bölünmüş qayda var',
                    'en' => 'Given Set was without from god divide rule Hath',
                    'ru' => 'Данный набор был без от бога разделить правило имеет'
                ],
                'excerpt' => [
                    'az' => 'Midst one brought greater also morning green saying had good.',
                    'en' => 'Midst one brought greater also morning green saying had good.',
                    'ru' => 'Среди всего принесенного больше также утреннее зеленое высказывание было хорошим.'
                ],
                'body' => [
                    'az' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                    'en' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                    'ru' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>'
                ],
                'author_name' => 'Admin',
                'reading_time' => 5,
                'status' => 1,
                'published_at' => $now,
                'is_active' => true,
                'sort_order' => 6,
                'image' => 'blog-6.jpg'
            ],
        ];

        foreach ($blogs as $index => $blogData) {
            $image = $blogData['image'] ?? ($blogImages[$index] ?? 'blog-1.jpg');
            unset($blogData['image']);
            
            $blog = Blog::create($blogData);
            
            // Add featured image
            $imagePath = public_path('storefront/images/blog/' . $image);
            if (file_exists($imagePath)) {
                $blog->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('featured');
            }
        }

        // Use factory to create additional blogs (20 more blogs)
        $additionalBlogs = Blog::factory()
            ->count(20)
            ->published()
            ->create();

        // Add images to factory-created blogs
        foreach ($additionalBlogs as $index => $blog) {
            // Cycle through available images
            $imageIndex = ($index % count($blogImages));
            $image = $blogImages[$imageIndex] ?? 'blog-1.jpg';
            $imagePath = public_path('storefront/images/blog/' . $image);
            
            if (file_exists($imagePath)) {
                $blog->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('featured');
            }
        }
    }
}

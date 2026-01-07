<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RegenerateMediaConversions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:regenerate
                            {--model= : Specific model to regenerate (product, category, blog, or all)}
                            {--force : Force regeneration even if conversions exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate media conversions including WebP for all models';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $model = $this->option('model') ?: 'all';
        $force = $this->option('force');

        $this->info('Starting media conversion regeneration...');

        if ($model === 'all' || $model === 'product') {
            $this->regenerateProductMedia($force);
        }

        if ($model === 'all' || $model === 'category') {
            $this->regenerateCategoryMedia($force);
        }

        if ($model === 'all' || $model === 'blog') {
            $this->regenerateBlogMedia($force);
        }

        if ($model === 'all' || $model === 'brand') {
            $this->regenerateBrandMedia($force);
        }

        if ($model === 'all' || $model === 'banner') {
            $this->regenerateBannerMedia($force);
        }

        if ($model === 'all' || $model === 'page') {
            $this->regeneratePageMedia($force);
        }

        $this->info('Media conversion regeneration completed!');

        return Command::SUCCESS;
    }

    /**
     * Regenerate product media conversions
     */
    protected function regenerateProductMedia(bool $force): void
    {
        $this->info('Regenerating Product media...');

        $products = Product::with('media')->get();
        $bar = $this->output->createProgressBar($products->count());

        foreach ($products as $product) {
            foreach ($product->getMedia('images') as $media) {
                $this->regenerateConversions($media, $force);
            }
            foreach ($product->getMedia('thumbnail') as $media) {
                $this->regenerateConversions($media, $force);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Processed {$products->count()} products.");
    }

    /**
     * Regenerate category media conversions
     */
    protected function regenerateCategoryMedia(bool $force): void
    {
        $this->info('Regenerating Category media...');

        $categories = Category::with('media')->get();
        $bar = $this->output->createProgressBar($categories->count());

        foreach ($categories as $category) {
            foreach ($category->getMedia('icon') as $media) {
                $this->regenerateConversions($media, $force);
            }
            foreach ($category->getMedia('banner') as $media) {
                $this->regenerateConversions($media, $force);
            }
            foreach ($category->getMedia('gallery') as $media) {
                $this->regenerateConversions($media, $force);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Processed {$categories->count()} categories.");
    }

    /**
     * Regenerate blog media conversions
     */
    protected function regenerateBlogMedia(bool $force): void
    {
        $this->info('Regenerating Blog media...');

        $blogs = Blog::with('media')->get();
        $bar = $this->output->createProgressBar($blogs->count());

        foreach ($blogs as $blog) {
            foreach ($blog->getMedia('featured') as $media) {
                $this->regenerateConversions($media, $force);
            }
            foreach ($blog->getMedia('gallery') as $media) {
                $this->regenerateConversions($media, $force);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Processed {$blogs->count()} blogs.");
    }

    /**
     * Regenerate brand media conversions
     */
    protected function regenerateBrandMedia(bool $force): void
    {
        $this->info('Regenerating Brand media...');

        $brands = Brand::with('media')->get();
        $bar = $this->output->createProgressBar($brands->count());

        foreach ($brands as $brand) {
            foreach ($brand->getMedia('logo') as $media) {
                $this->regenerateConversions($media, $force);
            }
            foreach ($brand->getMedia('banner') as $media) {
                $this->regenerateConversions($media, $force);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Processed {$brands->count()} brands.");
    }

    /**
     * Regenerate banner media conversions
     */
    protected function regenerateBannerMedia(bool $force): void
    {
        $this->info('Regenerating Banner media...');

        $banners = Banner::with('media')->get();
        $bar = $this->output->createProgressBar($banners->count());

        foreach ($banners as $banner) {
            foreach ($banner->getMedia('image') as $media) {
                $this->regenerateConversions($media, $force);
            }
            foreach ($banner->getMedia('image_mobile') as $media) {
                $this->regenerateConversions($media, $force);
            }
            foreach ($banner->getMedia('icon') as $media) {
                $this->regenerateConversions($media, $force);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Processed {$banners->count()} banners.");
    }

    /**
     * Regenerate page media conversions
     */
    protected function regeneratePageMedia(bool $force): void
    {
        $this->info('Regenerating Page media...');

        $pages = Page::with('media')->get();
        $bar = $this->output->createProgressBar($pages->count());

        foreach ($pages as $page) {
            foreach ($page->getMedia('featured') as $media) {
                $this->regenerateConversions($media, $force);
            }
            foreach ($page->getMedia('gallery') as $media) {
                $this->regenerateConversions($media, $force);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Processed {$pages->count()} pages.");
    }

    /**
     * Regenerate conversions for a media item
     */
    protected function regenerateConversions(Media $media, bool $force): void
    {
        try {
            if ($force) {
                // Delete existing conversions and regenerate
                $media->deleteGeneratedConversions();
            }

            // Regenerate all conversions for this media
            $media->model->registerMediaConversions($media);

            foreach ($media->getMediaConversionNames() as $conversionName) {
                if ($force || !$media->hasGeneratedConversion($conversionName)) {
                    $media->model->addMediaConversion($conversionName);
                }
            }
        } catch (\Exception $e) {
            $this->error("Error processing media ID {$media->id}: {$e->getMessage()}");
        }
    }
}

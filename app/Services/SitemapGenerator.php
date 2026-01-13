<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Page;
use App\Models\Brand;
use RuntimeException;
use App\Models\Product;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Support\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SitemapGenerator
{
    protected string $sitemapPath;
    protected string $baseUrl;
    protected array $locales;

    public function __construct()
    {
        $this->sitemapPath = public_path('sitemaps');
        $this->baseUrl = rtrim(config('app.url'), '/');
        $this->locales = Language::where('is_active', true)->pluck('code')->toArray();

        // Ensure sitemap directory exists
        if (!is_dir($this->sitemapPath) && !mkdir($concurrentDirectory = $this->sitemapPath, 0755, true) && !is_dir($concurrentDirectory)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
    }

    /**
     * Generate all sitemaps
     */
    public function generate(): void
    {
        $this->generateStaticSitemap();
        $this->generateCategoriesSitemap();
        $this->generateProductsSitemap();
        $this->generateBlogsSitemap();
        $this->generateBrandsSitemap();
        $this->generatePagesSitemap();
        $this->generateSitemapIndex();
    }

    /**
     * Generate sitemap index
     */
    protected function generateSitemapIndex(): void
    {
        $now = Carbon::now()->toW3cString();

        $sitemapIndex = SitemapIndex::create();

        $sitemaps = [
            'sitemap-static.xml',
            'sitemap-categories.xml',
            'sitemap-products.xml',
            'sitemap-blogs.xml',
            'sitemap-brands.xml',
            'sitemap-pages.xml',
        ];

        foreach ($sitemaps as $sitemap) {
            $sitemapIndex->add("{$this->baseUrl}/sitemaps/{$sitemap}");
        }

        $sitemapIndex->writeToFile("{$this->sitemapPath}/sitemap.xml");

        // Also write to public root for /sitemap.xml access
        $sitemapIndex->writeToFile(public_path('sitemap.xml'));
    }

    /**
     * Generate static pages sitemap
     */
    protected function generateStaticSitemap(): void
    {
        $sitemap = Sitemap::create();
        $now = Carbon::now();

        foreach ($this->locales as $locale) {
            // Home page
            $sitemap->add(
                Url::create("{$this->baseUrl}/{$locale}")
                    ->setLastModificationDate($now)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(1.0)
            );

            // Products index
            $sitemap->add(
                Url::create("{$this->baseUrl}/{$locale}/products")
                    ->setLastModificationDate($now)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.9)
            );

            // Categories index
            $sitemap->add(
                Url::create("{$this->baseUrl}/{$locale}/category")
                    ->setLastModificationDate($now)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.9)
            );

            // Brands index
            $sitemap->add(
                Url::create("{$this->baseUrl}/{$locale}/brands")
                    ->setLastModificationDate($now)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );

            // Blog index
            $sitemap->add(
                Url::create("{$this->baseUrl}/{$locale}/blog")
                    ->setLastModificationDate($now)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.8)
            );

            // Discounts index
            $sitemap->add(
                Url::create("{$this->baseUrl}/{$locale}/discount")
                    ->setLastModificationDate($now)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.8)
            );

            // New Products index
            $sitemap->add(
                Url::create("{$this->baseUrl}/{$locale}/new")
                    ->setLastModificationDate($now)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.8)
            );

            // Contact
            $sitemap->add(
                Url::create("{$this->baseUrl}/{$locale}/contact")
                    ->setLastModificationDate($now)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.6)
            );
        }

        $sitemap->writeToFile("{$this->sitemapPath}/sitemap-static.xml");
    }

    /**
     * Generate categories sitemap
     */
    protected function generateCategoriesSitemap(): void
    {
        $sitemap = Sitemap::create();
        $categories = Category::where('is_active', true)->get();

        foreach ($categories as $category) {
            foreach ($this->locales as $locale) {
                $sitemap->add(
                    Url::create("{$this->baseUrl}/{$locale}/category/{$category->slug}")
                        ->setLastModificationDate($category->updated_at ?? Carbon::now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.8)
                );
            }
        }

        $sitemap->writeToFile("{$this->sitemapPath}/sitemap-categories.xml");
    }

    /**
     * Generate products sitemap
     */
    protected function generateProductsSitemap(): void
    {
        $sitemap = Sitemap::create();
        $products = Product::where('is_active', true)->get();

        foreach ($products as $product) {
            foreach ($this->locales as $locale) {
                $url = Url::create("{$this->baseUrl}/{$locale}/products/{$product->slug}")
                    ->setLastModificationDate($product->updated_at ?? Carbon::now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7);

                // Add product image if exists
                $imageUrl = $product->getProductImageUrl();
                if ($imageUrl) {
                    $url->addImage($imageUrl, $product->getTranslation('name', $locale));
                }

                $sitemap->add($url);
            }
        }

        $sitemap->writeToFile("{$this->sitemapPath}/sitemap-products.xml");
    }

    /**
     * Generate blogs sitemap
     */
    protected function generateBlogsSitemap(): void
    {
        $sitemap = Sitemap::create();
        $blogs = Blog::published()->get();

        foreach ($blogs as $blog) {
            foreach ($this->locales as $locale) {
                $sitemap->add(
                    Url::create("{$this->baseUrl}/{$locale}/blog/{$blog->slug}")
                        ->setLastModificationDate($blog->updated_at ?? $blog->published_at ?? Carbon::now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.6)
                );
            }
        }

        $sitemap->writeToFile("{$this->sitemapPath}/sitemap-blogs.xml");
    }

    /**
     * Generate brands sitemap
     */
    protected function generateBrandsSitemap(): void
    {
        $sitemap = Sitemap::create();
        $brands = Brand::where('is_active', true)->get();

        foreach ($brands as $brand) {
            foreach ($this->locales as $locale) {
                $sitemap->add(
                    Url::create("{$this->baseUrl}/{$locale}/brand/{$brand->slug}")
                        ->setLastModificationDate($brand->updated_at ?? Carbon::now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.7)
                );
            }
        }

        $sitemap->writeToFile("{$this->sitemapPath}/sitemap-brands.xml");
    }

    /**
     * Generate pages sitemap
     */
    protected function generatePagesSitemap(): void
    {
        $sitemap = Sitemap::create();
        $pages = Page::where('is_active', true)->get();

        foreach ($pages as $page) {
            foreach ($this->locales as $locale) {
                $sitemap->add(
                    Url::create("{$this->baseUrl}/{$locale}/page/{$page->slug}")
                        ->setLastModificationDate($page->updated_at ?? Carbon::now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.5)
                );
            }
        }

        $sitemap->writeToFile("{$this->sitemapPath}/sitemap-pages.xml");
    }
}

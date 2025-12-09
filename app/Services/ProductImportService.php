<?php

namespace App\Services;

use Exception;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\Contracts\ProductImportServiceInterface;

class ProductImportService implements ProductImportServiceInterface
{
    /**
     * @var array|string[] $locales
     */
    protected array $locales = [
        'az',
        'en',
        'ru'
    ];

    /**
     * @param string $apiUrl
     * @param callable|null $onProgress
     * @return array
     */
    public function importFromApi(string $apiUrl, ?callable $onProgress = null): array
    {
        $stats = [
            'imported' => 0,
            'updated' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        $page = 1;
        $hasMorePages = true;

        while ($hasMorePages) {
            $url = $apiUrl . (str_contains($apiUrl, '?') ? '&' : '?') . "page=$page";

            try {
                $response = Http::timeout(30)->get($url);

                if (!$response->successful()) {
                    $stats['errors'][] = "Failed to fetch page $page: HTTP {$response->status()}";
                    break;
                }

                $data = $response->json();
                $products = $data['data'] ?? [];

                if (empty($products)) {
                    $hasMorePages = false;
                    continue;
                }

                foreach ($products as $apiProduct) {
                    $result = $this->importProduct($apiProduct);

                    if ($result['success']) {
                        if ($result['action'] === 'created') {
                            $stats['imported']++;
                        } else {
                            $stats['updated']++;
                        }
                    } else {
                        $stats['failed']++;
                        $stats['errors'][] = $result['error'];
                    }

                    if ($onProgress) {
                        $onProgress($result, $stats);
                    }
                }

                // Check for next page - if API has pagination meta
                $lastPage = $data['meta']['last_page'] ?? $data['last_page'] ?? null;
                $currentPage = $data['meta']['current_page'] ?? $data['current_page'] ?? $page;

                if ($lastPage !== null && $currentPage >= $lastPage) {
                    $hasMorePages = false;
                } elseif (count($products) === 0) {
                    $hasMorePages = false;
                }

                $page++;

            } catch (Exception $e) {
                $stats['errors'][] = "Page $page error: " . $e->getMessage();
                Log::error('Product import API error', [
                    'page' => $page,
                    'error' => $e->getMessage()
                ]);
                break;
            }
        }

        return $stats;
    }

    /**
     * Import a single product from API data
     *
     * @param array $apiProduct
     * @return array{success: bool, action: string, error: string|null}
     */
    public function importProduct(array $apiProduct): array
    {
        try {
            return DB::transaction(function () use ($apiProduct) {
                $sku = $apiProduct['sku'] ?? null;
                $slug = $apiProduct['slug'] ?? null;

                if (!$sku && !$slug) {
                    return [
                        'success' => false,
                        'action' => 'skipped',
                        'error' => "Product has no SKU or slug: " . json_encode($apiProduct['id'] ?? 'unknown')
                    ];
                }

                // Find existing product by SKU or slug
                $product = Product::withTrashed()
                    ->where('sku', $sku)
                    ->where('slug', $slug)
                    ->first();

                $isNew = !$product;

                if ($isNew) {
                    $product = new Product();
                }

                // Map and set product data
                $productData = $this->mapProductData($apiProduct);
                $product->fill($productData);

                // Handle Brand
                if (!empty($apiProduct['brand'])) {
                    $brand = $this->findOrCreateBrand($apiProduct['brand']);
                    $product->brand_id = $brand->id;
                }

                // Restore if soft deleted
                if ($product->trashed()) {
                    $product->restore();
                }

                $product->save();

                // Handle Categories (after save, need product ID)
                if (!empty($apiProduct['category'])) {
                    $categoryIds = $this->findOrCreateCategories($apiProduct['category']);
                    $product->categories()->sync($categoryIds);
                }

                // Handle Tags
                if (!empty($apiProduct['tags'])) {

                    $tagIds = $this->findOrCreateTags($apiProduct['tags']);
                    $product->tags()->sync($tagIds);
                }

                // Handle Media (images)
                $this->importProductMedia($product, $apiProduct);

                return [
                    'success' => true,
                    'action' => $isNew ? 'created' : 'updated',
                    'error' => null,
                    'product_id' => $product->id,
                    'slug' => $product->slug,
                ];
            });

        } catch (Exception $e) {
            Log::error('Product import failed', [
                'api_product' => $apiProduct['id'] ?? $apiProduct['sku'] ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'action' => 'failed',
                'error' => "Product " . ($apiProduct['sku'] ?? $apiProduct['slug'] ?? 'unknown') . ": " . $e->getMessage()
            ];
        }
    }

    /**
     * Map API product data to database fields
     *
     * @param array $apiProduct
     * @return array
     */
    protected function mapProductData(array $apiProduct): array
    {
        $translations = $apiProduct['translations'] ?? [];

        return [
            'sku' => $apiProduct['sku'] ?? Str::random(8),
            'slug' => $this->generateUniqueSlug($apiProduct['slug'] ?? Str::slug($apiProduct['title'] ?? '')),
            'price' => (float)($apiProduct['new_price'] ?? $apiProduct['price'] ?? 0),
            'currency' => 'AZN',
            'compare_at_price' => (float)($apiProduct['old_price'] ?? 0) > 0 ? (float)$apiProduct['old_price'] : 0,
            'stock_qty' => (int)($apiProduct['smoke_count'] ?? $apiProduct['stock_qty'] ?? 0),
            'is_active' => (bool)($apiProduct['is_stock'] ?? $apiProduct['is_active'] ?? true),
            'is_new' => (bool)($apiProduct['is_new'] ?? false),
            'is_featured' => (bool)($apiProduct['is_best_seller'] ?? $apiProduct['is_featured'] ?? false),
            'is_hot' => (bool)($apiProduct['is_hot'] ?? false),
            'name' => $this->extractTranslations($translations, 'title', $apiProduct['title'] ?? ''),
            'description' => $this->extractTranslations($translations, 'description'),
            'short_description' => $this->extractTranslations($translations, 'info'),
            'meta_title' => $this->extractTranslations($translations, 'meta_title'),
            'meta_description' => $this->extractTranslations($translations, 'meta_description'),
            'specs' => $this->extractSpecsData($translations, 'info'),
        ];
    }

    /**
     * @param $translations
     * @param $field
     * @param string $fallback
     * @return array
     */
    public function extractSpecsData($translations, $field, string $fallback = ''): array
    {
        $result = [];

        foreach ($this->locales as $locale) {
            $value = $translations[$locale][$field] ?? null;
            $result[$locale] = extractSpecsFromHtml($value);
        }

        return $result;
    }

    /**
     * Extract translations for a field from API translations array
     *
     * @param array $translations
     * @param string $field
     * @param string|null $fallback
     * @return array
     */
    protected function extractTranslations(array $translations, string $field, ?string $fallback = null): array
    {
        $result = [];

        foreach ($this->locales as $locale) {
            $value = $translations[$locale][$field] ?? null;

            if ($value === null && $locale === 'az' && $fallback !== null) {
                $value = $fallback;
            }

            if ($value !== null) {
                $result[$locale] = $value;
            }
        }

        return $result;
    }

    /**
     * Generate unique slug
     *
     * @param string $slug
     * @return string
     */
    protected function generateUniqueSlug(string $slug): string
    {
        if (empty($slug)) {
            $slug = Str::random(8);
        }

        $originalSlug = Str::slug($slug);
        $count = 1;
        $newSlug = $originalSlug;

        while (Product::withTrashed()->where('slug', $newSlug)->exists()) {
            $newSlug = $originalSlug . '-' . $count;
            $count++;
        }

        return $newSlug;
    }

    /**
     * @param array $apiBrand
     * @return Brand
     */
    protected function findOrCreateBrand(array $apiBrand): Brand
    {
        $slug = $apiBrand['slug'] ?? Str::slug($apiBrand['title'] ?? $apiBrand['name'] ?? '');

        /**
         * @var Brand|null $brand
         */
        $brand = Brand::withTrashed()->where('slug', $slug)->first();

        if ($brand) {
            if ($brand->trashed()) {
                $brand->restore();
            }
            return $brand;
        }

        // Extract translations
        $translations = $apiBrand['translations'] ?? [];
        $name = $this->extractBrandTranslations($translations, 'title', $apiBrand['title'] ?? $apiBrand['name'] ?? '');

        $brand = Brand::create([
            'slug' => $slug,
            'name' => $name,
            'is_active' => (bool)($apiBrand['status'] ?? true),
        ]);

        // Import brand logo if available
        if (!empty($apiBrand['base_image']['url'])) {
            $this->importMedia($brand, $apiBrand['base_image']['url'], 'logo');
        }

        return $brand;
    }

    /**
     * Extract brand translations
     *
     * @param array $translations
     * @param string $field
     * @param string $fallback
     * @return array
     */
    protected function extractBrandTranslations(array $translations, string $field, string $fallback = ''): array
    {
        $result = [];

        foreach ($this->locales as $locale) {
            $value = $translations[$locale][$field] ?? null;

            if ($value === null && $locale === 'az') {
                $value = $fallback;
            }

            if ($value !== null) {
                $result[$locale] = $value;
            }
        }

        return $result ?: ['az' => $fallback];
    }

    /**
     * Find or create categories from API data (handles parent-child)
     *
     * @param array $apiCategory
     * @return array Category IDs
     */
    protected function findOrCreateCategories(array $apiCategory): array
    {
        $categoryIds = [];

        $parentId = null;
        if (!empty($apiCategory['parent'])) {
            $parent = $this->findOrCreateSingleCategory($apiCategory['parent']);
            $parentId = $parent->id;
            $categoryIds[] = $parentId;
        }

        $category = $this->findOrCreateSingleCategory($apiCategory, $parentId);
        $categoryIds[] = $category->id;

        return array_unique($categoryIds);
    }

    /**
     * Find or create a single category
     *
     * @param array $apiCategory
     * @param int|null $parentId
     * @return Category
     */
    protected function findOrCreateSingleCategory(array $apiCategory, ?int $parentId = null): Category
    {
        $slug = $apiCategory['slug'] ?? Str::slug($apiCategory['title'] ?? $apiCategory['name'] ?? '');

        /**
         * @var Category|null $category
         */
        $category = Category::withTrashed()->where('slug', $slug)->first();

        if ($category) {
            if ($category->trashed()) {
                $category->restore();
            }
            return $category;
        }

        // Extract translations
        $translations = $apiCategory['translations'] ?? [];
        $name = $this->extractCategoryTranslations($translations, 'title', $apiCategory['title'] ?? $apiCategory['name'] ?? '');

        return Category::create([
            'slug' => $slug,
            'name' => $name,
            'parent_id' => $parentId,
            'is_active' => (bool)($apiCategory['status'] ?? true),
        ]);
    }

    /**
     * Extract category translations
     *
     * @param array $translations
     * @param string $field
     * @param string $fallback
     * @return array
     */
    protected function extractCategoryTranslations(array $translations, string $field, string $fallback = ''): array
    {
        $result = [];

        foreach ($this->locales as $locale) {
            $value = $translations[$locale][$field] ?? null;

            if ($value === null && $locale === 'az') {
                $value = $fallback;
            }

            if ($value !== null) {
                $result[$locale] = $value;
            }
        }

        return $result ?: ['az' => $fallback];
    }

    /**
     * @param array $translations
     * @param string $field
     * @param string $fallback
     * @return array|string[]
     */
    public function extractTagTranslations(array $translations, string $field, string $fallback = ''): array
    {
        $result = [];

        foreach ($this->locales as $locale) {
            $value = $translations[$locale][$field] ?? null;

            if ($value === null) {
                $value = $fallback;
            }

            if ($value !== null) {
                $result[$locale] = $value;
            }
        }

        return $result ?: ['az' => $fallback];
    }

    /**
     * Find or create tags from API data
     *
     * @param array $apiTags
     * @return array Tag IDs
     */
    protected function findOrCreateTags(array $apiTags): array
    {
        $tagIds = [];

        foreach ($apiTags as $apiTag) {
            $slug = $apiTag['slug'] ?? Str::slug($apiTag['name'] ?? '');

            if (empty($slug)) {
                continue;
            }

            $tag = Tag::withTrashed()->where('slug', $slug)->first();


            if (!$tag) {

                $tagName = $this->extractTagTranslations($apiTag['translations'] ?? [], 'title', $apiTag['name'] ?? '');

                $tag = Tag::create([
                    'slug' => $slug,
                    'name' => $tagName,
                    'is_active' => true,
                ]);
            } elseif ($tag->trashed()) {
                $tag->restore();
            }

            $tagIds[] = $tag->id;
        }

        return $tagIds;
    }

    /**
     * Import product media (images)
     *
     * @param Product $product
     * @param array $apiProduct
     * @return void
     */
    protected function importProductMedia(Product $product, array $apiProduct): void
    {
        // Import base image as thumbnail
        if (!empty($apiProduct['base_image']['url'])) {
            if (!$product->hasMedia('thumbnail')) {
                $this->importMedia($product, $apiProduct['base_image']['url'], 'thumbnail');
            }
        }

        // Import additional images
        if (!empty($apiProduct['additional_images']) && is_array($apiProduct['additional_images'])) {
            foreach ($apiProduct['additional_images'] as $image) {
                if (!empty($image['url'])) {
                    $this->importMedia($product, $image['url'], 'images');
                }
            }
        }
    }

    /**
     * Import media from URL
     *
     * @param HasMedia $model
     * @param string $url
     * @param string $collection
     * @return void
     */
    protected function importMedia(HasMedia $model, string $url, string $collection): void
    {
        try {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                return;
            }

            $model->addMediaFromUrl($url)
                ->toMediaCollection($collection);

        } catch (Exception $e) {
            Log::warning('Failed to import media', [
                'url' => $url,
                'collection' => $collection,
                'error' => $e->getMessage()
            ]);
        }
    }
}

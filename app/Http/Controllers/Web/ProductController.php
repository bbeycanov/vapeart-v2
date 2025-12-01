<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\ProductServiceInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\BrandServiceInterface;

class ProductController extends Controller
{
    /**
     * @param ProductServiceInterface $productService
     * @param CategoryServiceInterface $categoryService
     * @param BrandServiceInterface $brandService
     */
    public function __construct(
        private readonly ProductServiceInterface $productService,
        private readonly CategoryServiceInterface $categoryService,
        private readonly BrandServiceInterface $brandService
    )
    {
    }


    /**
     * @param string $locale
     * @param Request $request
     * @return Factory|View
     */
    public function index(string $locale, Request $request): Factory|View
    {
        app()->setLocale($locale);

        $filters = $request->only([
            'brand_id',
            'brand_ids',
            'category_id',
            'category_ids',
            'tag_id',
            'price_min',
            'price_max',
            'sort'
        ]);
        
        $page = $request->get('page', 1);
        $products = $this->productService->catalog($filters, perPage: 24, page: $page);
        
        // Get categories tree
        $categories = $this->categoryService->getTree();
        
        // Get all active brands
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('sort_order')->get();
        
        // Get price range from products
        $priceMin = Product::where('is_active', true)->min('price') ?? 0;
        $priceMax = Product::where('is_active', true)->max('price') ?? 1000;

        // Always return full page - JavaScript will parse it
        return view('pages.products.index', compact('products', 'categories', 'brands', 'priceMin', 'priceMax', 'filters'));
    }
    
    /**
     * Load more products via AJAX
     * 
     * @param string $locale
     * @param Request $request
     * @return Factory|View
     */
    public function loadMore(string $locale, Request $request): Factory|View
    {
        app()->setLocale($locale);

        $filters = $request->only([
            'brand_id',
            'brand_ids',
            'category_id',
            'category_ids',
            'tag_id',
            'price_min',
            'price_max',
            'sort'
        ]);
        
        $page = $request->get('page', 1);
        $products = $this->productService->catalog($filters, perPage: 24, page: $page);

        return view('pages.products._products_grid', compact('products'));
    }

    /**
     * @param string $locale
     * @param Product $product
     * @return Factory|View
     */
    public function show(string $locale, Product $product): Factory|View
    {
        app()->setLocale($locale);

        // Get product with all relations (cached via service)
        $product = $this->productService->getBySlug($product->slug);
        
        if (!$product || !$product->is_active) {
            abort(404);
        }

        // Build schema for SEO (cached via service)
        $schemaJsonLd = $this->productService->buildSchemaFor($product);

        // Get related products (cached via service)
        $relatedProducts = $this->productService->getRelatedProducts($product, 8);

        // Get reviews
        $reviews = $product->reviews()->where('status', 1)->latest('published_at')->get();

        // Get discount information
        $bestDiscount = $product->getBestDiscount();
        $discountedPrice = $product->getDiscountedPrice();
        $discountText = $product->getDiscountText();
        $hasDiscount = $bestDiscount !== null;
        $originalPrice = $product->price;

        // Prepare product data for view
        $productData = [
            'id' => $product->id,
            'name' => $product->getTranslation('name', $locale),
            'slug' => $product->slug,
            'sku' => $product->sku,
            'price' => $hasDiscount ? $discountedPrice : $product->price,
            'original_price' => $originalPrice,
            'sale_price' => $product->compare_at_price,
            'discount_text' => $discountText,
            'has_discount' => $hasDiscount,
            'currency' => $product->currency,
            'short_description' => $product->getTranslation('short_description', $locale),
            'description' => $product->getTranslation('description', $locale),
            'stock_quantity' => $product->stock_qty,
            'is_track_stock' => $product->is_track_stock,
            'rating_avg' => $product->rating_avg ?? 0,
            'reviews_count' => $product->reviews_count ?? 0,
            'images' => $this->getProductImages($product),
            'attributes' => $product->attributes ?? [],
            'specs' => $this->parseSpecs($product->getTranslation('specs', $locale)),
            'brand' => $product->brand ? [
                'id' => $product->brand->id,
                'name' => $product->brand->getTranslation('name', $locale),
                'slug' => $product->brand->slug,
                'logo' => $product->brand->getFirstMediaUrl('logo'),
            ] : null,
            'categories' => $product->categories->map(function ($category) use ($locale) {
                return [
                    'id' => $category->id,
                    'name' => $category->getTranslation('name', $locale),
                    'slug' => $category->slug,
                ];
            }),
            'tags' => $product->tags->map(function ($tag) use ($locale) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->getTranslation('name', $locale),
                    'slug' => $tag->slug,
                ];
            }),
        ];

        return view('pages.products.show', compact('product', 'productData', 'schemaJsonLd', 'relatedProducts', 'reviews'));
    }

    /**
     * Get all product images (thumbnail first, then additional images)
     */
    private function getProductImages(Product $product): array
    {
        $images = [];

        // First add thumbnail/base image
        $thumbnail = $product->getFirstMedia('thumbnail');
        if ($thumbnail) {
            $images[] = $thumbnail->getUrl();
        }

        // Then add additional images
        $additionalImages = $product->getMedia('images');
        foreach ($additionalImages as $media) {
            $images[] = $media->getUrl();
        }

        // Fallback to gallery if no images found
        if (empty($images)) {
            $galleryImages = $product->getMedia('gallery');
            foreach ($galleryImages as $media) {
                $images[] = $media->getUrl();
            }
        }

        return $images;
    }

    /**
     * Parse specs from various formats to array
     */
    private function parseSpecs(mixed $specs): array
    {
        if (empty($specs)) {
            return [];
        }

        if (is_array($specs)) {
            return $specs;
        }

        if (is_string($specs)) {
            // Try to decode if JSON string
            $decoded = json_decode($specs, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            // Parse HTML table or list format
            return $this->parseHtmlSpecs($specs);
        }

        return [];
    }

    /**
     * Parse HTML specs to key-value array
     */
    private function parseHtmlSpecs(string $html): array
    {
        $specs = [];

        // Remove HTML tags but keep content structured
        $text = strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>', '</li>', '</tr>'], "\n", $html));
        $lines = array_filter(array_map('trim', explode("\n", $text)));

        foreach ($lines as $line) {
            // Try to split by common delimiters
            if (str_contains($line, ':')) {
                [$key, $value] = array_pad(explode(':', $line, 2), 2, '');
                $key = trim($key);
                $value = trim($value);
                if ($key && $value) {
                    $specs[$key] = $value;
                }
            }
        }

        return $specs;
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class QuickViewController extends Controller
{
    /**
     * @param string $locale
     * @param Request $request
     * @return Factory|View|JsonResponse
     */
    public function show(string $locale, Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        app()->setLocale($locale);

            $product = Product::with(['brand', 'categories', 'tags', 'media', 'discounts' => function ($q) {
                $q->active();
            }])
            ->findOrFail($request->product_id);

        if ($request->expectsJson()) {
            // Get images with medium conversion for quick view (standardized size: 512x512)
            $images = $product->getMedia('images');
            if ($images->isEmpty()) {
                $thumbnail = $product->getFirstMedia('thumbnail');
                $images = $thumbnail ? collect([$thumbnail]) : collect();
            }
            
            $imageUrls = $images->map(function($media) use ($product) {
                try {
                    $url = $media->getUrl('medium');
                    // Ensure we're using the conversion, not original
                    if ($url && $url !== $media->getUrl()) {
                        return $url;
                    }
                    // If conversion doesn't exist, use original but log it
                    return $media->getUrl();
                } catch (\Exception $e) {
                    return $media->getUrl();
                }
            })->filter()->toArray();
            
            // If no images, use placeholder
            if (empty($imageUrls)) {
                $imageUrls = [asset('storefront/images/products/placeholder.jpg')];
            }
            
            // Get thumbnail image for cart (thumb conversion - standardized size: 256x256)
            $thumbImage = $product->getProductImageUrl('thumb');
            
            $categories = $product->categories->map(function($category) {
                return $category->getTranslation('name', app()->getLocale());
            })->implode(', ');
            
            $tags = $product->tags->map(function($tag) {
                return $tag->getTranslation('name', app()->getLocale());
            })->implode(', ');
            
            // Get discount information
            $bestDiscount = $product->getBestDiscount();
            $discountedPrice = $product->getDiscountedPrice();
            $discountText = $product->getDiscountText();
            $hasDiscount = $bestDiscount !== null;
            $originalPrice = $product->price;
            
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->getTranslation('name', app()->getLocale()),
                    'slug' => $product->slug,
                    'price' => $hasDiscount ? $discountedPrice : $originalPrice, // Use discounted price if available
                    'original_price' => $originalPrice, // Keep original price for reference
                    'sale_price' => $product->compare_at_price,
                    'discount_text' => $discountText,
                    'has_discount' => $hasDiscount,
                    'currency' => $product->currency ?? 'AZN',
                    'short_description' => $product->getTranslation('short_description', app()->getLocale()),
                    'description' => $product->getTranslation('description', app()->getLocale()),
                    'brand' => $product->brand ? $product->brand->getTranslation('name', app()->getLocale()) : null,
                    'sku' => $product->sku ?? 'N/A',
                    'categories' => $categories ?: 'N/A',
                    'tags' => $tags ?: 'N/A',
                    'rating_avg' => $product->rating_avg ?? 0,
                    'reviews_count' => $product->reviews_count ?? 0,
                    'stock_quantity' => $product->stock_qty ?? 0,
                    'image' => $thumbImage, // For cart - thumb conversion
                    'images' => $imageUrls, // For quick view - medium conversion
                    'url' => route('products.show', [app()->getLocale(), $product->slug]),
                ]
            ]);
        }

        return view('includes.quick-view', compact('product'));
    }
}


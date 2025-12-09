<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;

class QuickViewController extends Controller
{
    /**
     * @param string $locale
     * @param Request $request
     * @return Factory|View|JsonResponse
     */
    public function show(string $locale, Request $request): Factory|View|JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        app()->setLocale($locale);

            $product = Product::with(['brand', 'categories', 'tags', 'media', 'discounts' => function ($q) {
                $q->active();
            }])
            ->findOrFail($request->input('product_id'));

        if ($request->expectsJson()) {
            // Get base image (thumbnail) and additional images
            $allImages = collect();

            // 1. First add base image (thumbnail) - must be first
            $thumbnail = $product->getFirstMedia('thumbnail');
            if ($thumbnail) {
                $allImages->push($thumbnail);
            }

            // 2. Then add additional images from 'images' collection
            $additionalImages = $product->getMedia('images');
            if ($additionalImages->isNotEmpty()) {
                $allImages = $allImages->merge($additionalImages);
            }

            // Convert to URLs
            $imageUrls = $allImages->map(function($media) use ($product) {
                try {
                    $url = $media->getUrl('large');
                    // Ensure we're using the conversion, not original
                    if ($url && $url !== $media->getUrl()) {
                        return $url;
                    }
                    // If conversion doesn't exist, use original but log it
                    return $media->getUrl();
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                    return $media->getUrl();
                }
            })->filter()->values()->toArray();

            // If no images, use placeholder
            if (empty($imageUrls)) {
                $imageUrls = [asset('storefront/images/products/placeholder.jpg')];
            }

            // Get thumbnail image for cart (thumb conversion - standardized size: 256x256)
            $thumbImage = $product->getProductImageUrl();

            // Categories with ID and slug for links
            $categories = $product->categories->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->getTranslation('name', app()->getLocale()),
                    'slug' => $category->slug
                ];
            })->toArray();

            $tags = $product->tags->map(function($tag) {
                return $tag->getTranslation('name', app()->getLocale());
            })->implode(', ');

            // Brand with logo and slug
            $brandData = null;
            if ($product->brand) {
                $brandData = [
                    'name' => $product->brand->getTranslation('name', app()->getLocale()),
                    'slug' => $product->brand->slug,
                    'logo' => $product->brand->getFirstMediaUrl('logo')
                ];
            }

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
                    'brand' => $brandData,
                    'sku' => $product->sku ?? 'N/A',
                    'categories' => $categories,
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


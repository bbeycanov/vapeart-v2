<?php

namespace App\Http\Controllers\Web;

use App\Enums\BannerPosition;
use Illuminate\Http\Request;
use Spatie\SchemaOrg\Schema;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\Contracts\BannerServiceInterface;
use App\Services\Contracts\ProductServiceInterface;

class DiscountController extends Controller
{
    /**
     * @param ProductServiceInterface $products
     * @param BannerServiceInterface $bannerService
     */
    public function __construct(
        private readonly ProductServiceInterface $products,
        private readonly BannerServiceInterface  $bannerService
    )
    {
    }

    /**
     * Display a listing of discounted products
     *
     * @param string $locale
     * @param Request $request
     * @return Factory|View
     */
    public function index(string $locale, Request $request): Factory|View
    {
        app()->setLocale($locale);

        $filters = $request->only([
            'brand_id',
            'category_id',
            'tag_id',
            'price_min',
            'price_max',
            'sort'
        ]);

        $filters['on_discount'] = true;

        $list = $this->products->catalog($filters);

        if ($request->ajax()) {
            return view('pages.discounts._products_grid', compact('list'));
        }

        $banner = $this->bannerService->byPosition(BannerPosition::DISCOUNTS_INDEX_HEADER)->first();

        $schemaJsonLd = $this->buildSchemaFor($list);

        return view('pages.discounts.index', compact('list', 'banner', 'schemaJsonLd'));
    }

    /**
     * Build structured data schema for discounts page
     *
     * @param LengthAwarePaginator $products
     * @return string
     */
    private function buildSchemaFor(LengthAwarePaginator $products): string
    {
        $locale = app()->getLocale();
        $url = route('discount.index', ['locale' => $locale]);
        $pageTitle = __('page.Discounted Products');

        // WebPage Schema
        $webPage = Schema::collectionPage()
            ->name($pageTitle)
            ->url($url)
            ->inLanguage($locale)
            ->description(__('page.Browse our discounted products and save on your favorite items.'));

        // Breadcrumb Schema
        $breadcrumb = Schema::breadcrumbList()->itemListElement([
            Schema::listItem()->position(1)->name(__('navigation.Home'))->item(route('home', $locale)),
            Schema::listItem()->position(2)->name($pageTitle)->item($url),
        ]);

        // ItemList Schema with products
        $itemListElements = [];
        $position = 1;

        foreach ($products as $product) {
            $productName = $product->getTranslation('name', $locale);
            $productUrl = route('products.show', ['locale' => $locale, 'product' => $product->slug]);
            $originalPrice = (float)$product->price;
            $bestDiscount = $product->getBestDiscount();
            $discountedPrice = $bestDiscount ? (float)$product->getDiscountedPrice() : $originalPrice;
            $productImage = $product->getFirstMediaUrl('images', 'large') ?: asset('storefront/images/product-placeholder.jpg');

            $offer = Schema::offer()
                ->url($productUrl)
                ->priceCurrency('AZN')
                ->price($discountedPrice)
                ->availability($product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock')
                ->itemCondition('https://schema.org/NewCondition');

            // Add discount validity if available
            if ($bestDiscount && isset($bestDiscount->end_date) && $bestDiscount->end_date) {
                $endDate = $bestDiscount->end_date;
                if ($endDate instanceof \Carbon\Carbon) {
                    $offer->priceValidUntil($endDate->format('Y-m-d'));
                } elseif (is_string($endDate)) {
                    $offer->priceValidUntil(date('Y-m-d', strtotime($endDate)));
                }
            }

            $productSchema = Schema::product()
                ->name($productName)
                ->url($productUrl)
                ->image($productImage)
                ->offers($offer);

            if ($product->sku) {
                $productSchema->sku($product->sku);
            }

            $itemListElements[] = Schema::listItem()
                ->position($position)
                ->item($productSchema);

            $position++;
        }

        $itemList = Schema::itemList()
            ->itemListElement($itemListElements)
            ->numberOfItems($products->total());

        return $webPage->toScript() . PHP_EOL . $breadcrumb->toScript() . PHP_EOL . $itemList->toScript();
    }
}


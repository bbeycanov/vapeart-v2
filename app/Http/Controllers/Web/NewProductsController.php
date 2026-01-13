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

class NewProductsController extends Controller
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
     * Display a listing of new products
     *
     * @param string $locale
     * @param Request $request
     * @return Factory|View
     */
    public function index(string $locale, Request $request): Factory|View
    {
        app()->setLocale($locale);

        $filters = $request->only(['sort']);

        $filters['sort'] = $filters['sort'] ?? 'created_desc';

        $page = $request->get('page', 1);

        $list = $this->products->catalog(
            filters: $filters,
            perPage: 24,
            page: $page
        );

        $banner = $this->bannerService->byPosition(BannerPosition::NEW_PRODUCTS_INDEX_HEADER)->first();

        $schemaJsonLd = $this->buildSchemaFor($list);

        return view('pages.new-products.index', compact('list', 'banner', 'schemaJsonLd'));
    }

    /**
     * Build structured data schema for new products page
     *
     * @param LengthAwarePaginator $products
     * @return string
     */
    private function buildSchemaFor(LengthAwarePaginator $products): string
    {
        $locale = app()->getLocale();
        $url = route('new.index', ['locale' => $locale]);
        $pageTitle = __('page.New Products');

        // WebPage Schema
        $webPage = Schema::collectionPage()
            ->name($pageTitle)
            ->url($url)
            ->inLanguage($locale)
            ->description(__('page.Discover our latest arrivals and newest products.'));

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


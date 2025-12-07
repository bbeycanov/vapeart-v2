<?php

namespace App\Http\Controllers\Web;

use App\Models\Menu;
use App\Enums\MenuPosition;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\MenuServiceInterface;

class MenuController extends Controller
{
    /**
     * @param MenuServiceInterface $menus
     */
    public function __construct(
        private readonly MenuServiceInterface $menus
    )
    {
    }

    /**
     * @param string $locale
     * @param string $position
     * @return JsonResponse
     */
    public function byPosition(string $locale, string $position): JsonResponse
    {
        app()->setLocale($locale);
        $tree = $this->menus->getTree(MenuPosition::from($position)->value);
        return response()->json($tree);
    }

    /**
     * @param string $locale
     * @param Menu $menu
     * @return Factory|View
     */
    public function brands(string $locale, Menu $menu): Factory|View
    {
        app()->setLocale($locale);

        // Get brands from products that belong to this menu
        $menuProducts = $menu->products()
            ->where('is_active', true)
            ->whereNotNull('brand_id')
            ->with('brand')
            ->get();

        // Group by brand and count products
        $brands = $menuProducts
            ->groupBy('brand_id')
            ->map(function ($products) {
                $brand = $products->first()->brand;

                if (!$brand) {
                    return null;
                }

                return [
                    'brand' => $brand,
                    'product_count' => $products->count()
                ];
            })
            ->filter()
            ->sortByDesc('product_count')
            ->values();

        return view('pages.catalog.brands', compact('menu', 'brands'));
    }
}

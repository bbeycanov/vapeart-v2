<?php

namespace App\Http\Controllers\Web;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;

class CartController extends Controller
{
    /**
     * @param string $locale
     * @return Factory|View
     */
    public function index(string $locale): Factory|View
    {
        app()->setLocale($locale);

        $branches = Branch::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($branch) {
                return [
                    'id' => $branch->id,
                    'name' => $branch->getTranslation('name', app()->getLocale()),
                    'address' => $branch->getTranslation('address', app()->getLocale()),
                    'phone' => $branch->phone,
                    'whatsapp' => $branch->whatsapp,
                ];
            });

        return view('pages.carts.index', compact('branches'));
    }

    /**
     * @param string $locale
     * @param Request $request
     * @return JsonResponse
     */
    public function getBranches(string $locale, Request $request): JsonResponse
    {
        app()->setLocale($locale);

        $query = Branch::where('is_active', true);

        // Alkoqol məhdudiyyəti: əgər sorğuda product_id varsa və həmin məhsul
        // alkoqol kateqoriyasındadırsa, yalnız alkoqol satan filiallar göstərilir.
        $productId = $request->query('product_id');
        if ($productId && $this->productIsAlcohol((int) $productId)) {
            $query->where('sells_alcohol', true);
        }

        $branches = $query->orderBy('sort_order')
            ->get()
            ->map(function ($branch) {
                return [
                    'id' => $branch->id,
                    'name' => $branch->getTranslation('name', app()->getLocale()),
                    'address' => $branch->getTranslation('address', app()->getLocale()),
                    'phone' => $branch->phone,
                    'whatsapp' => $branch->whatsapp,
                ];
            });

        return response()->json([
            'success' => true,
            'branches' => $branches
        ]);
    }

    /**
     * Məhsul alkoqol kateqoriyasına (is_alcohol) və ya onun alt-kateqoriyasına
     * aiddirmi? Kateqoriya ağacı `path` (məs. "/29/") ilə yoxlanılır.
     *
     * @param int $productId
     * @return bool
     */
    private function productIsAlcohol(int $productId): bool
    {
        $alcoholRootIds = Category::where('is_alcohol', true)->pluck('id');

        if ($alcoholRootIds->isEmpty()) {
            return false;
        }

        // Alkoqol kök kateqoriyaları + onların bütün alt-kateqoriyaları (path ilə).
        $alcoholCategoryIds = Category::query()
            ->where(function ($q) use ($alcoholRootIds) {
                $q->whereIn('id', $alcoholRootIds);
                foreach ($alcoholRootIds as $rootId) {
                    $q->orWhere('path', 'like', '%/' . $rootId . '/%');
                }
            })
            ->pluck('id');

        return DB::table('product_categories')
            ->where('product_id', $productId)
            ->whereIn('category_id', $alcoholCategoryIds)
            ->exists();
    }

    /**
     * @param string $locale
     * @param Request $request
     * @return JsonResponse
     */
    public function add(string $locale, Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'sometimes|integer|min:1'
        ]);

        app()->setLocale($locale);

        $product = Product::with([
            'brand',
            'media'
        ])->findOrFail($request->post('product_id'));

        $quantity = $request->input('quantity', 1);

        return response()->json([
            'success' => true,
            'message' => __('Product added to cart successfully'),
            'product' => [
                'id' => $product->id,
                'name' => $product->getTranslation('name', app()->getLocale()),
                'slug' => $product->slug,
                'price' => $product->price,
                'currency' => $product->currency ?? 'AZN',
                'image' => $product->getFirstMediaUrl('thumbnail') ?: $product->getFirstMediaUrl('images'),
                'url' => route('products.show', [
                    app()->getLocale(),
                    $product->slug
                ]),
                'quantity' => $quantity,
            ]
        ]);
    }
}


<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\ElasticsearchService;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    /**
     * Search products via API (for autocomplete)
     *
     * @param string $locale
     * @param Request $request
     * @param ElasticsearchService $elasticsearchService
     * @return JsonResponse
     */
    public function autocomplete(string $locale, Request $request, ElasticsearchService $elasticsearchService): JsonResponse
    {
        app()->setLocale($locale);

        $query = $request->get('q', '');

        if (empty($query) || strlen($query) < 1) {
            return response()->json(['products' => []]);
        }

        try {
            // Search in Elasticsearch
            $results = $elasticsearchService->search($query);
            $productIds = array_map(fn($hit) => $hit['_source']['id'], $results['hits']);

            if (empty($productIds)) {
                return response()->json([
                    'products' => [],
                    'total' => 0
                ]);
            }

            // Get products from database
            $products = Product::whereIn('id', $productIds)
                ->with([
                    'brand',
                    'categories',
                    'tags'
                ])
                ->get()
                ->sortBy(function ($product) use ($productIds) {
                    return array_search($product->id, $productIds);
                })
                ->values()
                ->map(function ($product) use ($locale) {
                    return [
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'name' => $product->getTranslation('name', $locale),
                        'price' => number_format($product->price, 2),
                        'currency' => $product->currency ?? 'AZN',
                        'image' => $product->getProductImageUrl('thumb'),
                        'url' => route('products.show', [
                            $locale,
                            $product->slug
                        ]),
                    ];
                });

            return response()->json([
                'products' => $products,
                'total' => $results['total'],
            ]);
        } catch (Exception $e) {
            // Fallback to database search if Elasticsearch fails
            Log::error('Elasticsearch search failed: ' . $e->getMessage());

            $products = Product::where('is_active', true)
                ->where(function ($q) use ($query, $locale) {
                    $q->whereRaw("JSON_EXTRACT(name, '$.$locale') LIKE ?", ["%$query%"])
                        ->orWhereRaw("JSON_EXTRACT(short_description, '$.$locale') LIKE ?", ["%$query%"])
                        ->orWhereRaw("JSON_EXTRACT(description, '$.$locale') LIKE ?", ["%$query%"]);
                })
                ->with([
                    'brand',
                    'categories'
                ])
                ->take(10)
                ->get()
                ->map(function ($product) use ($locale) {
                    return [
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'name' => $product->getTranslation('name', $locale),
                        'price' => number_format($product->price, 2),
                        'currency' => $product->currency ?? 'AZN',
                        'image' => $product->getProductImageUrl('thumb'),
                        'url' => route('products.show', [
                            $locale,
                            $product->slug
                        ]),
                    ];
                });

            return response()->json([
                'products' => $products,
                'total' => $products->count(),
            ]);
        }
    }

    /**
     * Search products page (View All Results)
     *
     * @param string $locale
     * @param Request $request
     * @param ElasticsearchService $elasticsearchService
     * @return Factory|View
     */
    public function index(string $locale, Request $request, ElasticsearchService $elasticsearchService): Factory|View
    {
        app()->setLocale($locale);

        $query = $request->get('q', '');
        $page = $request->get('page', 1);
        $perPage = $request->get('perPage', 24);

        try {
            if (!empty($query)) {
                // Search in Elasticsearch
                $from = ($page - 1) * $perPage;
                $results = $elasticsearchService->search($query, $from, $perPage);
                $productIds = array_map(fn($hit) => $hit['_source']['id'], $results['hits']);

                if (empty($productIds)) {
                    $products = new LengthAwarePaginator([], $results['total'], $perPage, $page, [
                        'path' => $request->url(),
                        'query' => $request->query(),
                    ]);
                } else {
                    // Get products from database maintaining order
                    $dbProducts = Product::whereIn('id', $productIds)
                        ->with([
                            'brand',
                            'categories',
                            'tags'
                        ])
                        ->get()
                        ->keyBy('id');

                    $orderedProducts = collect($productIds)
                        ->map(fn($id) => $dbProducts->get($id))
                        ->filter();

                    $products = new LengthAwarePaginator(
                        $orderedProducts,
                        $results['total'],
                        $perPage,
                        $page,
                        [
                            'path' => $request->url(),
                            'query' => $request->query(),
                        ]
                    );
                }
            } else {
                // If no query, show featured products
                $products = Product::where('is_active', true)
                    ->where('is_featured', true)
                    ->orderBy('sort_order')
                    ->paginate($perPage);
            }
        } catch (Exception $e) {
            Log::error('Elasticsearch search failed: ' . $e->getMessage());

            if (!empty($query)) {
                $products = Product::where('is_active', true)
                    ->where(function ($q) use ($query, $locale) {
                        $q->whereRaw("JSON_EXTRACT(name, '$.$locale') LIKE ?", ["%$query%"])
                            ->orWhereRaw("JSON_EXTRACT(short_description, '$.$locale') LIKE ?", ["%$query%"])
                            ->orWhereRaw("JSON_EXTRACT(description, '$.$locale') LIKE ?", ["%$query%"]);
                    })
                    ->with([
                        'brand',
                        'categories'
                    ])
                    ->orderBy('sort_order')
                    ->paginate($perPage);
            } else {
                $products = Product::where('is_active', true)
                    ->where('is_featured', true)
                    ->orderBy('sort_order')
                    ->paginate($perPage);
            }
        }

        return view('pages.search.index', compact('products', 'query'));
    }
}

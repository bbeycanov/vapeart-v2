<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\ProductServiceInterface;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryServiceInterface $cats,
        private readonly ProductServiceInterface  $products
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

        $parentId = $request->get('parent_id');
        $parentCategory = $parentId ? \App\Models\Category::find($parentId) : null;
        
        $categories = $this->cats->getTree($parentId);
        
        // Get product counts for each category
        $categoriesWithCounts = $categories->map(function ($category) {
            $productCount = $category->products()
                ->where('is_active', true)
                ->count();
            
            return [
                'category' => $category,
                'product_count' => $productCount
            ];
        });

        return view('pages.categories.index', compact('categoriesWithCounts', 'parentCategory'));
    }

    /**
     * @param string $locale
     * @param Category $category
     * @param Request $request
     * @return Factory|View
     */
    public function show(string $locale, Category $category, Request $request): Factory|View
    {
        app()->setLocale($locale);

        $schemaJsonLd = $this->cats->buildSchemaFor($category);

        $filters = $request->only([
            'brand_id',
            'tag_id',
            'price_min',
            'price_max',
            'sort'
        ]);
        $filters['category_id'] = $category->id;

        $list = $this->products->catalog($filters);

        // Get brands that have products in this category
        $brands = $category->products()
            ->where('is_active', true)
            ->whereNotNull('brand_id')
            ->with('brand')
            ->get()
            ->pluck('brand')
            ->filter()
            ->unique('id')
            ->sortBy(function ($brand) {
                return $brand->getTranslation('name', app()->getLocale());
            })
            ->values();

        return view(
            'pages.categories.show',
            compact(
                'category',
                'list',
                'brands',
                'schemaJsonLd'
            )
        );
    }
}

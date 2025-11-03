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
     * @return Factory|View
     */
    public function index(string $locale): Factory|View
    {
        app()->setLocale($locale);

        $tree = $this->cats->getTree();
        return view('pages.categories.index', compact('tree'));
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

        return view(
            'pages.categories.show',
            compact(
                'category',
                'list',
                'schemaJsonLd'
            )
        );
    }
}

<?php

namespace App\Http\Controllers\Web;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\PageServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    /**
     * @param PageServiceInterface $pages
     */
    public function __construct(
        private readonly PageServiceInterface $pages
    )
    {
    }

    /**
     * @param string $locale
     * @param string $slug
     * @return Factory|View
     */
    public function show(string $locale, string $slug): Factory|View
    {
        app()->setLocale($locale);

        $page = $this->pages->getBySlug(slug: $slug);

        if (!$page) throw new NotFoundHttpException();

        $schemaJsonLdScripts = $this->pages->buildSchemaFor($page);

        return view('pages.pages.show', compact('page', 'schemaJsonLdScripts'));
    }
}

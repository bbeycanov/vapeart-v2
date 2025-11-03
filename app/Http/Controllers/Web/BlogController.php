<?php


namespace App\Http\Controllers\Web;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\BlogServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends Controller
{
    /**
     * @param BlogServiceInterface $svc
     */
    public function __construct(
        private readonly BlogServiceInterface $svc
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
        $blogs = $this->svc->index(['status' => 'published']);
        return view('pages.blog.index', compact('blogs'));
    }

    /**
     * @param string $locale
     * @param string $slug
     * @return Factory|View
     */
    public function show(string $locale, string $slug): Factory|View
    {
        app()->setLocale($locale);

        $blog = $this->svc->getBySlug($slug);

        if (!$blog) throw new NotFoundHttpException();

        $schemaJsonLd = $this->svc->buildSchemaFor($blog);

        return view('pages.blog.show', compact('blog', 'schemaJsonLd'));
    }
}

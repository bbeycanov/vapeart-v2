<?php


namespace App\Http\Controllers\Web;

use App\Models\Blog;
use App\Enums\BannerPosition;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\BlogServiceInterface;
use App\Services\Contracts\BannerServiceInterface;
use App\Services\Contracts\ReviewServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends Controller
{
    /**
     * @param BlogServiceInterface $svc
     * @param BannerServiceInterface $bannerService
     * @param ReviewServiceInterface $reviewService
     */
    public function __construct(
        private readonly BlogServiceInterface $svc,
        private readonly BannerServiceInterface $bannerService,
        private readonly ReviewServiceInterface $reviewService
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
        $blogs = $this->svc->index(['status' => 'published'], 9);
        $schemaJsonLd = $this->svc->buildIndexSchema();
        $banner = $this->bannerService->byPosition(BannerPosition::BLOG_INDEX_HEADER)->first();
        return view('pages.blog.index', compact('blogs', 'schemaJsonLd', 'banner'));
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
        $previousBlog = $this->svc->getPrevious($blog);
        $nextBlog = $this->svc->getNext($blog);
        $reviews = $this->reviewService->listFor(Blog::class, $blog->id);

        return view('pages.blog.show', compact('blog', 'schemaJsonLd', 'previousBlog', 'nextBlog', 'reviews'));
    }

    /**
     * Load more blogs via AJAX
     *
     * @param string $locale
     * @return JsonResponse
     */
    public function loadMore(string $locale): JsonResponse
    {
        app()->setLocale($locale);
        $page = (int)request('page', 2);

        // Create a new request with the page parameter
        $request = request()->duplicate(['page' => $page]);

        // Temporarily replace the request
        $originalRequest = request();
        app()->instance('request', $request);

        try {
            $blogs = $this->svc->index(['status' => 'published'], 9);

            $html = view('pages.blog.partials.blog-items', ['blogs' => $blogs->items()])->render();

            return response()->json([
                'html' => $html,
                'hasMore' => $blogs->hasMorePages(),
                'nextPage' => $blogs->hasMorePages() ? $page + 1 : null
            ]);
        } finally {
            // Restore original request
            app()->instance('request', $originalRequest);
        }
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreReviewRequest;
use App\Services\Contracts\ReviewServiceInterface;
use App\Services\Contracts\BlogServiceInterface;

class ReviewController extends Controller
{
    /**
     * @param ReviewServiceInterface $svc
     * @param BlogServiceInterface $blogService
     */
    public function __construct(
        private readonly ReviewServiceInterface $svc,
        private readonly BlogServiceInterface $blogService
    )
    {
    }

    /**
     * @param string $locale
     * @param Product $product
     * @param StoreReviewRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(string $locale, Product $product, StoreReviewRequest $request): JsonResponse|RedirectResponse
    {
        app()->setLocale($locale);

        try {
        $data = $request->validated();
        $data['status'] = 1;
        $data['published_at'] = now();

        $review = $this->svc->createFor(Product::class, $product->id, $data);

        $stat = $product
            ->reviews()
            ->where('status', 1)
            ->selectRaw('count(*) as c, avg(rating) as r')
            ->first();

        $product->update([
            'reviews_count' => (int)($stat->c ?? 0),
            'rating_avg' => round((float)($stat->r ?? 0), 2),
        ]);

            // If AJAX request, return JSON
            if ($request->wantsJson() || $request->ajax()) {
                $reviewHtml = view('pages.products.partials.review-item', [
                    'review' => $review,
                    'locale' => $locale
                ])->render();

                return response()->json([
                    'success' => true,
                    'message' => __('Thanks for your review!'),
                    'review' => $reviewHtml,
                    'reviews_count' => (int)($stat->c ?? 0),
                    'rating_avg' => round((float)($stat->r ?? 0), 2),
                ]);
            }

        return back()->with('success', __('Thanks for your review!'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('Validation failed'),
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: __('An error occurred while submitting your review')
                ], 500);
            }
            throw $e;
        }
    }

    /**
     * @param string $locale
     * @param string $slug
     * @param StoreReviewRequest $request
     * @return JsonResponse
     */
    public function storeBlog(string $locale, string $slug, StoreReviewRequest $request): JsonResponse
    {
        app()->setLocale($locale);

        $blog = $this->blogService->getBySlug($slug);
        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => __('Blog not found')
            ], 404);
        }

        try {
            $data = $request->validated();
            $data['status'] = 1;
            $data['published_at'] = now();

            $review = $this->svc->createFor(Blog::class, $blog->id, $data);

            $reviewHtml = view('pages.blog.partials.review-item', [
                'review' => $review,
                'locale' => $locale
            ])->render();

            return response()->json([
                'success' => true,
                'message' => __('Thanks for your review!'),
                'review' => $reviewHtml
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Validation failed'),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: __('An error occurred while submitting your review')
            ], 500);
        }
    }
}

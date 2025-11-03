<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreReviewRequest;
use App\Services\Contracts\ReviewServiceInterface;

class ReviewController extends Controller
{
    /**
     * @param ReviewServiceInterface $svc
     */
    public function __construct(
        private readonly ReviewServiceInterface $svc
    )
    {
    }

    /**
     * @param string $locale
     * @param Product $product
     * @param StoreReviewRequest $request
     * @return RedirectResponse
     */
    public function store(string $locale, Product $product, StoreReviewRequest $request): RedirectResponse
    {
        app()->setLocale($locale);

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

        return back()->with('success', __('Thanks for your review!'));
    }
}

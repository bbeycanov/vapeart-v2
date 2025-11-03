<?php

namespace App\Http\Controllers\Web;

use App\Enums\BannerPosition;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\BannerServiceInterface;

class BannerController extends Controller
{
    /**
     * @param BannerServiceInterface $svc
     */
    public function __construct(
        private readonly BannerServiceInterface $svc
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
        $pos = BannerPosition::from($position)->value;
        $banners = $this->svc->byPosition($pos);
        $schema = $this->svc->buildSchemaForList($banners);

        return response()->json([
            'data' => $banners,
            'schema' => $schema,
        ]);
    }

    /**
     * @param string $locale
     * @param string $key
     * @return JsonResponse
     */
    public function showByKey(string $locale, string $key): JsonResponse
    {
        $banner = $this->svc->byKey($key);
        abort_if(!$banner, 404);
        $schema = $this->svc->buildSchemaFor($banner);

        return response()->json([
            'data' => $banner,
            'schema' => $schema,
        ]);
    }
}

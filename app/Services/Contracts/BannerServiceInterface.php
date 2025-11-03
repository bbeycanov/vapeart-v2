<?php

namespace App\Services\Contracts;

use App\Models\Banner;
use App\Enums\BannerPosition;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface BannerServiceInterface
{
    /**
     * @param BannerPosition|string $position
     * @param array|null $types
     * @return Collection
     */
    public function byPosition(BannerPosition|string $position, ?array $types = null): Collection;

    /**
     * @param string $key
     * @return Banner|null
     */
    public function byKey(string $key): ?Banner;

    /**
     * @param array $data
     * @return Banner
     */
    public function create(array $data): Banner;

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool;

    /**
     * @param Banner $banner
     * @param mixed $file
     * @param string $collection
     * @return Banner
     */
    public function attachImage(Banner $banner, mixed $file, string $collection = 'image'): Banner;

    /**
     * @param Banner $banner
     * @return string
     */
    public function buildSchemaFor(Banner $banner): string;

    /**
     * @param Collection $banners
     * @return string
     */
    public function buildSchemaForList(Collection $banners): string;
}

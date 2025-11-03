<?php

namespace App\Repositories\Contracts;

use App\Enums\BannerPosition;
use Illuminate\Support\Collection;

interface BannerRepositoryInterface extends RepositoryInterface
{
    /**
     * @param BannerPosition|string $position
     * @param array|null $types
     * @return Collection
     */
    public function listByPosition(BannerPosition|string $position, ?array $types = null): Collection;

    /**
     * @param string $key
     * @return mixed
     */
    public function findByKey(string $key): mixed;
}

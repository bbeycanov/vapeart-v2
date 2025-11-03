<?php


namespace App\Repositories;

use App\Models\Banner;
use App\Enums\BannerPosition;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BannerRepositoryInterface;

class BannerRepository extends BaseRepository implements BannerRepositoryInterface
{
    public static function modelClass(): string
    {
        return Banner::class;
    }

    public function __construct(Banner $model)
    {
        parent::__construct($model);
    }

    /**
     * @param BannerPosition|string $position
     * @param array|null $types
     * @return Collection
     */
    public function listByPosition(BannerPosition|string $position, ?array $types = null): Collection
    {
        $pos = $position instanceof BannerPosition ? $position->value : $position;

        $builder = $this->query()
            ->where('position', $pos)
            ->active()
            ->inSchedule()
            ->when($types, fn($q) => $q->whereIn('type', $types))
            ->orderBy('sort_order');

        if (!$this->isCacheEnabled()) return $builder->get();

        $key = $this->cacheKey('listByPosition', [
            $pos,
            $types,
            app()->getLocale()
        ]);
        return $this->remember($key, fn() => $builder->get());
    }

    /**
     * @param string $key
     * @return Model|null
     */
    public function findByKey(string $key): ?Model
    {
        return $this->firstWhere(['key' => $key]);
    }
}

<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * @return string
     */
    public static function modelClass(): string
    {
        return Category::class;
    }

    /**
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $slug
     * @return Category|null
     */
    public function findBySlug(string $slug): ?Category
    {
        return $this->firstWhere(['slug' => $slug])->first();
    }

    /**
     * @param int|null $rootId
     * @return Collection
     */
    public function getTree(?int $rootId = null): Collection
    {
        $builder = $this->query()
            ->active()
            ->when($rootId, fn($q) => $q->where('parent_id', $rootId),
                fn($q) => $q->whereNull('parent_id'))
            ->with([
                'children' => function ($q) {
                    $q->active()->with([
                        'children' => function ($qq) {
                            $qq->active()->with('children');
                        }
                    ]);
                }
            ])
            ->orderBy('sort_order');

        if (!$this->isCacheEnabled()) {
            return $builder->get();
        }

        $key = $this->cacheKey('tree', [
            'root' => $rootId,
            'loc' => app()->getLocale()
        ]);
        return $this->remember($key, fn() => $builder->get());
    }
}

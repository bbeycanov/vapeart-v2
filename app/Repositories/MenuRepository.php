<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Enums\MenuPosition;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\MenuRepositoryInterface;

class MenuRepository extends BaseRepository implements MenuRepositoryInterface
{
    /**
     * @return string
     */
    public static function modelClass(): string
    {
        return Menu::class;
    }

    /**
     * @param Menu $model
     */
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }

    /**
     * @param MenuPosition|string $position
     * @return Collection
     */
    public function getTreeByPosition(MenuPosition|string $position): Collection
    {
        $pos = $position instanceof MenuPosition ? $position->value : $position;

        $builder = $this->query()
            ->position($pos)
            ->active()
            ->whereNull('parent_id')
            ->with([
                'media',
                'children' => function ($q) {
                    $q->active()->with([
                        'media',
                        'children' => function ($qq) {
                            $qq->active()->with(['children', 'media']);
                        },
                        'widgets.media'
                    ]);
                },
                'widgets.media'
            ])
            ->orderBy('sort_order');

        if (!$this->isCacheEnabled()) {
            return $builder->get();
        }

        $key = $this->cacheKey('treeByPosition', [
            $pos,
            app()->getLocale()
        ]);

        return $this->remember($key, fn() => $builder->get());
    }
}

<?php

namespace App\Services;

use App\Enums\MenuPosition;
use App\Models\Menu;
use App\Repositories\Contracts\MenuRepositoryInterface;
use App\Services\Contracts\MenuServiceInterface;
use Illuminate\Support\Collection;

class MenuService extends AbstractService implements MenuServiceInterface
{
    /**
     * @param MenuRepositoryInterface $repo
     * @param Menu $model
     */
    public function __construct(
        private readonly MenuRepositoryInterface $repo,
        Menu                                     $model
    )
    {
        parent::__construct($model);
        $this->cachePrefix('svc:menu:');
    }

    /**
     * @param MenuPosition|string $position
     * @return Collection
     */
    public function getTree(MenuPosition|string $position): Collection
    {
        $pos = $position instanceof MenuPosition ? $position->value : $position;

        return $this->cached('tree', [
            'pos' => $pos,
            'loc' => app()->getLocale()
        ], function () use ($pos) {
            return $this->repo->getTreeByPosition($pos);
        });
    }
}

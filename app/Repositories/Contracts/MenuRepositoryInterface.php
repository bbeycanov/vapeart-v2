<?php

namespace App\Repositories\Contracts;

use App\Enums\MenuPosition;
use Illuminate\Support\Collection;

interface MenuRepositoryInterface extends RepositoryInterface
{
    /**
     * @param MenuPosition|string $position
     * @return Collection
     */
    public function getTreeByPosition(MenuPosition|string $position): Collection;
}

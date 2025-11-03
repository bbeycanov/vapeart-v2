<?php


namespace App\Services\Contracts;

use App\Enums\MenuPosition;
use Illuminate\Support\Collection;

interface MenuServiceInterface
{
    /**
     * @param MenuPosition|string $position
     * @return Collection
     */
    public function getTree(MenuPosition|string $position): Collection;
}

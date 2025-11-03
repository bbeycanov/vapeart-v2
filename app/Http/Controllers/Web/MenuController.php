<?php

namespace App\Http\Controllers\Web;

use App\Enums\MenuPosition;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\MenuServiceInterface;

class MenuController extends Controller
{
    /**
     * @param MenuServiceInterface $menus
     */
    public function __construct(
        private readonly MenuServiceInterface $menus
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
        $tree = $this->menus->getTree(MenuPosition::from($position)->value);
        return response()->json($tree);
    }
}

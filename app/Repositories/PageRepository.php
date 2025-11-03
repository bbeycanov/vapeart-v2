<?php

namespace App\Repositories;

use App\Models\Page;
use App\Repositories\Contracts\PageRepositoryInterface;

class PageRepository extends BaseRepository implements PageRepositoryInterface
{
    /**
     * @return string
     */
    public static function modelClass(): string
    {
        return Page::class;
    }

    /**
     * @param Page $model
     */
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $slug
     * @return Page|null
     */
    public function findBySlug(string $slug): ?Page
    {
        return $this->firstWhere(['slug' => $slug])->first();
    }

    /**
     * @param string $slug
     * @return Page|null
     */
    public function findPublishedBySlug(string $slug): ?Page
    {
        return $this->query()->published()->where('slug', $slug)->first();
    }
}

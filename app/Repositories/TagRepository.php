<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    /**
     * @param Tag $model
     */
    public function __construct(Tag $model)
    {
        parent::__construct($model);
    }

    /**
     * @return string
     */
    public static function modelClass(): string
    {
        return Tag::class;
    }

    /**
     * @param string $slug
     * @return Tag|null
     */
    public function findBySlug(string $slug): ?Tag
    {
        return $this->firstWhere(['slug' => $slug])->first();
    }
}

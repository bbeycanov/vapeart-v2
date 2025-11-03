<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;
use App\Services\Contracts\TagServiceInterface;
use Illuminate\Support\Facades\App;

class TagService extends AbstractService implements TagServiceInterface
{
    /**
     * @param TagRepositoryInterface $repo
     * @param Tag $model
     */
    public function __construct(
        private readonly TagRepositoryInterface $repo,
        Tag                                     $model
    )
    {
        parent::__construct($model);
        $this->cachePrefix('svc:tag:');
    }

    /**
     * @param string $slug
     * @return Tag|null
     */
    public function getBySlug(string $slug): ?Tag
    {
        return $this->remember($this->cacheKey('bySlug', [
            $slug,
            App::getLocale()
        ]),
            fn() => $this->repo->findBySlug($slug));
    }
}

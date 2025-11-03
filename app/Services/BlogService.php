<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Support\Str;
use Spatie\SchemaOrg\Schema;
use InvalidArgumentException;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use App\Services\Contracts\BlogServiceInterface;
use App\Repositories\Contracts\BlogRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;

class BlogService extends AbstractService implements BlogServiceInterface
{
    /**
     * @param BlogRepositoryInterface $repo
     * @param Blog $model
     */
    public function __construct(
        private readonly BlogRepositoryInterface $repo,
        Blog $model
    )
    {
        parent::__construct($model);
        $this->cachePrefix('svc:blog:');
    }

    /**
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function index(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $where = ['is_active' => true];

        if (($filters['status'] ?? null) === 'published') {
            $where['status'] = 1;
            $where[] = [
                'published_at',
                '<=',
                now()
            ];
        }

        return $this->paginate($perPage, $where);
    }

    /**
     * @param string $slug
     * @param bool $onlyPublished
     * @return Blog|null
     */
    public function getBySlug(string $slug, bool $onlyPublished = true): ?Blog
    {
        $key = $this->cacheKey('bySlug', [
            $slug,
            $onlyPublished,
            App::getLocale()
        ]);
        return $this->remember($key, function () use ($slug, $onlyPublished) {
            return $onlyPublished
                ? $this->repo->findPublishedBySlug($slug)
                : $this->repo->findBySlug($slug);
        });
    }

    /**
     * @param array $data
     * @return Blog
     */
    public function create(array $data): Blog
    {
        return $this->tx(function () use ($data) {
            if (empty($data['slug'])) {
                $locale = App::getLocale();
                $title = $data['title'][$locale] ?? reset($data['title']) ?? 'blog';
                $data['slug'] = Str::slug($title);
            }
            if (($data['status'] ?? 0) == 1 && empty($data['published_at'])) {
                $data['published_at'] = now();
            }
            /** @var Blog $blog */
            $blog = $this->model->create($data);
            $this->flushServiceCache();
            return $blog;
        });
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool
    {
        if (!$model instanceof Blog) {
            throw new InvalidArgumentException('BlogService::update expects Blog model.');
        }

        return $this->tx(function () use ($model, $data) {
            if (array_key_exists('status', $data) && (int)$data['status'] === 1 && empty($model->published_at)) {
                $data['published_at'] = now();
            }
            $ok = $model->update($data);
            $this->flushServiceCache();
            return $ok;
        });
    }

    /**
     * @param Blog $blog
     * @param mixed $file
     * @return Blog
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function attachFeatured(Blog $blog, mixed $file): Blog
    {
        $blog->addMedia($file)->toMediaCollection('featured');
        $this->flushServiceCache();
        return $blog->refresh();
    }

    /**
     * @param Blog $blog
     * @param mixed $file
     * @return Blog
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function addToGallery(Blog $blog, mixed $file): Blog
    {
        $blog->addMedia($file)->toMediaCollection('gallery');
        $this->flushServiceCache();
        return $blog->refresh();
    }

    /**
     * @param Blog $blog
     * @return string
     */
    public function buildSchemaFor(Blog $blog): string
    {
        $locale = App::getLocale();
        $title = $blog->getTranslation('meta_title', $locale) ?: $blog->getTranslation('title', $locale);
        $desc = $blog->getTranslation('meta_description', $locale) ?: $blog->getTranslation('excerpt', $locale);

        $url = route('blog.show', [
            'locale' => $locale,
            'slug' => $blog->slug
        ]);

        $schema = Schema::blogPosting()
            ->headline($title)
            ->description($desc)
            ->inLanguage($locale)
            ->url($url)
            ->datePublished(optional($blog->published_at)->toIso8601String())
            ->dateModified(optional($blog->updated_at)->toIso8601String());

        if ($img = $blog->getFirstMediaUrl('featured')) {
            $schema->image($img);
        }
        if ($blog->author_name) {
            $schema->author(Schema::person()->name($blog->author_name));
        }

        return $schema->toScript();
    }
}

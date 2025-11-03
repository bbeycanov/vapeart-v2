<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;
use Spatie\SchemaOrg\Schema;
use InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use App\Services\Contracts\CategoryServiceInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;

class CategoryService extends AbstractService implements CategoryServiceInterface
{
    /**
     * @param CategoryRepositoryInterface $repo
     * @param Category $model
     */
    public function __construct(
        private readonly CategoryRepositoryInterface $repo,
        Category                                     $model
    )
    {
        parent::__construct($model);
        $this->cachePrefix('svc:pcat:');
    }

    /**
     * @param int|null $rootId
     * @return Collection
     */
    public function getTree(?int $rootId = null): Collection
    {
        return $this->cached('tree', [
            'root' => $rootId,
            'loc' => App::getLocale()
        ], function () use ($rootId) {
            return $this->repo->getTree($rootId);
        });
    }

    /**
     * @param string $slug
     * @return Category|null
     */
    public function getBySlug(string $slug): ?Category
    {
        $key = $this->cacheKey('bySlug', [
            $slug,
            App::getLocale()
        ]);
        return $this->remember($key, fn() => $this->repo->findBySlug($slug));
    }

    /**
     * @param Category $category
     * @return string
     */
    public function buildSchemaFor(Category $category): string
    {
        $locale = app()->getLocale();
        $title = $category->getTranslation('meta_title', $locale) ?: $category->getTranslation('name', $locale);
        $desc = $category->getTranslation('meta_description', $locale) ?: $category->getTranslation('description', $locale);

        $url = route('categories.show', ['locale' => $locale, 'category' => 'test'], false);

        $collection = Schema::collectionPage()
            ->name($title)
            ->url($url)
            ->inLanguage($locale)
            ->description($desc);

        if ($img = $category->getFirstMediaUrl('banner')) {
            $collection->image($img);
        }

        $children = $category->children()->active()->get();
        if ($children->isNotEmpty()) {
            $itemList = Schema::itemList()
                ->name($title . ' subcategories')
                ->numberOfItems($children->count())
                ->itemListElement(
                    $children->map(fn($child, $index) => Schema::listItem()
                        ->position($index + 1)
                        ->name($child->getTranslation('name', $locale))
                        ->url(route('categories.show', [
                            'locale' => $locale,
                            'slug' => $child->slug
                        ], true))
                    )->toArray()
                );

            $collection->hasPart($itemList);
        }

        return $collection->toScript();
    }

    /**
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category
    {
        return $this->tx(function () use ($data) {
            if (empty($data['slug'])) {
                $locale = App::getLocale();
                $name = $data['name'][$locale] ?? reset($data['name']) ?? 'category';
                $data['slug'] = Str::slug($name);
            }

            [
                $data['depth'],
                $data['path']
            ] = $this->computeDepthAndPath(
                $data['parent_id'] ?? null,
                $data['slug']
            );

            /** @var Category $cat */
            $cat = $this->model->create($data);
            $this->flushServiceCache();
            return $cat;
        });
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool
    {
        if (!$model instanceof Category) {
            throw new InvalidArgumentException('ProductCategoryService::update expects ProductCategory model.');
        }

        return $this->tx(function () use ($model, $data) {
            if (array_key_exists('parent_id', $data) || array_key_exists('slug', $data)) {
                $slug = $data['slug'] ?? $model->slug;
                [
                    $data['depth'],
                    $data['path']
                ] = $this->computeDepthAndPath(
                    $data['parent_id'] ?? $model->parent_id,
                    $slug
                );
            }

            $ok = $model->update($data);

            $this->flushServiceCache();
            return $ok;
        });
    }

    /**
     * @param int|null $parentId
     * @param string $slug
     * @return array
     */
    protected function computeDepthAndPath(?int $parentId, string $slug): array
    {
        if (!$parentId) {
            return [
                0,
                $slug
            ];
        }
        $parent = $this->repo->find($parentId);
        $depth = ($parent?->depth ?? -1) + 1;
        $path = trim(($parent?->path ? $parent->path . '/' : '') . $slug, '/');
        return [
            $depth,
            $path
        ];
    }

    /**
     * @param Category $cat
     * @param mixed $file
     * @return Category
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function attachIcon(Category $cat, mixed $file): Category
    {
        $cat->addMedia($file)->toMediaCollection('icon');
        $this->flushServiceCache();
        return $cat->refresh();
    }

    /**
     * @param Category $cat
     * @param mixed $file
     * @return Category
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function attachBanner(Category $cat, mixed $file): Category
    {
        $cat->addMedia($file)->toMediaCollection('banner');
        $this->flushServiceCache();
        return $cat->refresh();
    }
}

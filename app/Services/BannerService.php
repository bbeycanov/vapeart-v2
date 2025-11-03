<?php

namespace App\Services;

use App\Models\Banner;
use App\Enums\BannerType;
use Illuminate\Support\Str;
use Spatie\SchemaOrg\Schema;
use App\Enums\BannerPosition;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Psr\SimpleCache\InvalidArgumentException;
use App\Services\Contracts\BannerServiceInterface;
use App\Repositories\Contracts\BannerRepositoryInterface;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;

class BannerService extends AbstractService implements BannerServiceInterface
{
    /**
     * @param BannerRepositoryInterface $repo
     * @param Banner $model
     */
    public function __construct(
        private readonly BannerRepositoryInterface $repo,
        Banner                                     $model
    )
    {
        parent::__construct($model);
        $this->cachePrefix('svc:banner:');
    }

    /**
     * @param BannerPosition|string $position
     * @param array|null $types
     * @return Collection
     */
    public function byPosition(BannerPosition|string $position, ?array $types = null): Collection
    {
        $pos = $position instanceof BannerPosition ? $position->value : $position;

        return $this->cached(
            'byPos',
            [
                'pos' => $pos,
                'types' => $types,
                'loc' => App::getLocale()
            ],
            fn() => $this->repo->listByPosition($pos, $types)
        );
    }

    /**
     * @param string $key
     * @return Banner|null
     */
    public function byKey(string $key): ?Banner
    {
        $k = $this->cacheKey('byKey', [
            $key,
            App::getLocale()
        ]);

        return $this->remember($k, fn() => $this->repo->findByKey($key));
    }

    public function create(array $data): Banner
    {
        return $this->tx(function () use ($data) {
            if (empty($data['key'])) {
                $locale = App::getLocale();
                $title = $data['title'][$locale] ?? ($data['title'][array_key_first($data['title'] ?? [])] ?? 'banner');
                $data['key'] = Str::slug(($data['position'] ?? 'banner') . ' ' . $title . ' ' . uniqid());
            }
            /** @var Banner $banner */
            $banner = $this->model->create($data);
            $this->flushServiceCache();
            return $banner;
        });
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool
    {
        if (!$model instanceof Banner) {
            throw new \InvalidArgumentException('BannerService::update expects Banner.');
        }
        return $this->tx(function () use ($model, $data) {
            $ok = $model->update($data);
            $this->flushServiceCache();
            return $ok;
        });
    }

    /**
     * @param Banner $banner
     * @param mixed $file
     * @param string $collection
     * @return Banner
     * @throws InvalidArgumentException
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function attachImage(Banner $banner, mixed $file, string $collection = 'image'): Banner
    {
        $banner->addMedia($file)->toMediaCollection($collection);
        $this->flushServiceCache();
        return $banner->refresh();
    }

    /**
     * @param Banner $banner
     * @return string
     */
    public function buildSchemaFor(Banner $banner): string
    {
        $loc = App::getLocale();
        $title = $banner->getTranslation('title', $loc) ?? null;
        $desc = $banner->getTranslation('content', $loc) ?? null;
        $cta = $banner->getTranslation('link_text', $loc) ?? null;
        $href = $banner->getTranslation('link_url', $loc) ?? null;

        $imageUrl = $banner->getFirstMediaUrl('image') ?: $banner->getFirstMediaUrl('image_mobile');
        $videoUrl = $banner->getFirstMediaUrl('video');

        if ($banner->type === BannerType::VIDEO->value && $videoUrl) {
            $schema = Schema::videoObject()
                ->name($title)
                ->description($desc)
                ->inLanguage($loc)
                ->contentUrl($videoUrl);
            if ($imageUrl) $schema->thumbnailUrl($imageUrl);
        } else {
            $schema = Schema::imageObject()
                ->name($title)
                ->caption($desc)
                ->inLanguage($loc)
                ->contentUrl($imageUrl ?: $href);
        }

        if ($href) {
            $schema->mainEntityOfPage(
                Schema::webPage()->url($href)->name($cta ?: $title)
            );
        }

        return $schema->toScript();
    }

    /**
     * @param Collection $banners
     * @return string
     */
    public function buildSchemaForList(Collection $banners): string
    {
        $loc = App::getLocale();
        $list = Schema::itemList()
            ->inLanguage($loc)
            ->numberOfItems($banners->count())
            ->itemListElement(
                $banners->values()->map(function (Banner $b, $i) use ($loc) {
                    $name = $b->getTranslation('title', $loc) ?? $b->key;
                    $url = $b->getTranslation('link_url', $loc);
                    return Schema::listItem()
                        ->position($i + 1)
                        ->name($name)
                        ->url($url ?: null);
                })->toArray()
            );

        $scripts = $list->toScript();
        foreach ($banners as $b) {
            $scripts .= PHP_EOL . $this->buildSchemaFor($b);
        }
        return $scripts;
    }
}

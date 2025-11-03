<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Support\Str;
use Spatie\SchemaOrg\Schema;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use App\Services\Contracts\PageServiceInterface;
use App\Repositories\Contracts\PageRepositoryInterface;

class PageService extends AbstractService implements PageServiceInterface
{
    /**
     * @param PageRepositoryInterface $pages
     * @param Page $model
     */
    public function __construct(private readonly PageRepositoryInterface $pages, Page $model)
    {
        parent::__construct($model);

        $this->cachePrefix('svc:page:')
            ->cacheTtl((int)config('repo.cache.ttl', 3600));
    }

    /**
     * @param string $slug
     * @param bool $onlyPublished
     * @return Page|null
     */
    public function getBySlug(string $slug, bool $onlyPublished = true): ?Page
    {
        $key = $this->cacheKey('bySlug', [
            $slug,
            $onlyPublished,
            app()->getLocale()
        ]);

        return $this->remember($key, function () use ($slug, $onlyPublished) {
            return $onlyPublished
                ? $this->pages->findPublishedBySlug($slug)
                : $this->pages->findBySlug($slug);
        });
    }

    /**
     * @param Page $page
     * @return string
     */
    public function buildSchemaFor(Page $page): string
    {
        $locale = App::getLocale();
        $title = $page->getTranslation('meta_title', $locale) ?: $page->getTranslation('title', $locale);
        $desc = $page->getTranslation('meta_description', $locale) ?: $page->getTranslation('excerpt', $locale);
        $url = url(route('pages.show', ['slug' => $page->slug], false));

        $webPage = Schema::webPage()
            ->name($title)
            ->url($url)
            ->inLanguage($locale)
            ->description($desc);

        if ($media = $page->getFirstMediaUrl('featured')) {
            $webPage->image($media);
        }

        $breadcrumb = Schema::breadcrumbList()->itemListElement([
            Schema::listItem()->position(1)->name(__('Home'))->item(url('/')),
            Schema::listItem()->position(2)->name($title)->item($url),
        ]);

        return $webPage->toScript() . PHP_EOL . $breadcrumb->toScript();
    }

    /**
     * @param array $data
     * @return Page
     */
    public function create(array $data): Page
    {
        return $this->tx(function () use ($data) {
            if (empty($data['slug'])) {
                $locale = app()->getLocale();
                $title = $data['title'][$locale] ?? reset($data['title']) ?? 'page';
                $data['slug'] = Str::slug($title);
            }
            if (($data['status'] ?? 0) == 1 && empty($data['published_at'])) {
                $data['published_at'] = now();
            }
            $page = $this->pages->create($data);
            $this->flushServiceCache();
            return $page;
        });
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool
    {
        return $this->tx(function () use ($model, $data) {
            if (array_key_exists('status', $data) && (int)$data['status'] === 1 && empty($model->published_at)) {
                $data['published_at'] = now();
            }
            $ok = $this->pages->update($model, $data);
            $this->flushServiceCache();
            return $ok;
        });
    }
}

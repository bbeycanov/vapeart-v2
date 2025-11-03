<?php

namespace App\Services;

use App\Models\Brand;
use Spatie\SchemaOrg\Schema;
use Illuminate\Support\Facades\App;
use App\Services\Contracts\BrandServiceInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;

class BrandService extends AbstractService implements BrandServiceInterface
{
    /**
     * @param BrandRepositoryInterface $repo
     * @param Brand $model
     */
    public function __construct(
        private readonly BrandRepositoryInterface $repo,
        Brand                                     $model
    )
    {
        parent::__construct($model);
        $this->cachePrefix('svc:brand:');
    }

    /**
     * @param string $slug
     * @return Brand|null
     */
    public function getBySlug(string $slug): ?Brand
    {
        return $this->remember($this->cacheKey('bySlug', [
            $slug,
            App::getLocale()
        ]),
            fn() => $this->repo->findBySlug($slug));
    }

    /**
     * @param Brand $brand
     * @return string
     */
    public function buildSchemaFor(Brand $brand): string
    {
        $loc = App::getLocale();
        $name = $brand->getTranslation('name', $loc);
        $desc = $brand->getTranslation('description', $loc);
        $logo = $brand->getFirstMediaUrl('logo');

        $url = route('brands.show', [
            'locale' => $loc,
            'brand' => $brand->slug
        ]);

        $schema = Schema::brand()->name($name)->description($desc)->url($url);
        if ($logo) $schema->logo($logo);

        return $schema->toScript();
    }
}

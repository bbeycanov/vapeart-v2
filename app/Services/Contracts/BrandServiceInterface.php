<?php


namespace App\Services\Contracts;

use App\Models\Brand;

interface BrandServiceInterface
{
    /**
     * @param string $slug
     * @return Brand|null
     */
    public function getBySlug(string $slug): ?Brand;

    /**
     * @param Brand $brand
     * @return string
     */
    public function buildSchemaFor(Brand $brand): string;
}

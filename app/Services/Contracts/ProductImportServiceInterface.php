<?php

namespace App\Services\Contracts;

interface ProductImportServiceInterface
{
    /**
     * Import products from external API
     *
     * @param string $apiUrl
     * @param callable|null $onProgress
     * @return array{imported: int, updated: int, failed: int, errors: array}
     */
    public function importFromApi(string $apiUrl, ?callable $onProgress = null): array;

    /**
     * Import a single product from API data
     *
     * @param array $apiProduct
     * @return array{success: bool, action: string, error: string|null}
     */
    public function importProduct(array $apiProduct): array;
}
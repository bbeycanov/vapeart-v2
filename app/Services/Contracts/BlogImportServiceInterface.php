<?php

namespace App\Services\Contracts;

interface BlogImportServiceInterface
{
    /**
     * Import blogs from external API
     *
     * @param string $apiUrl
     * @param callable|null $onProgress
     * @return array{imported: int, updated: int, failed: int, errors: array}
     */
    public function importFromApi(string $apiUrl, ?callable $onProgress = null): array;

    /**
     * Import a single blog from API data
     *
     * @param array $apiBlog
     * @return array{success: bool, action: string, error: string|null}
     */
    public function importBlog(array $apiBlog): array;
}

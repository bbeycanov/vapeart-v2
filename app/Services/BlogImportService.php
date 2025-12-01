<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\Contracts\BlogImportServiceInterface;

class BlogImportService implements BlogImportServiceInterface
{
    /**
     * Supported locales for translations
     */
    protected array $locales = ['az', 'en', 'ru'];

    /**
     * Import blogs from external API with pagination support
     *
     * @param string $apiUrl
     * @param callable|null $onProgress
     * @return array{imported: int, updated: int, failed: int, errors: array}
     */
    public function importFromApi(string $apiUrl, ?callable $onProgress = null): array
    {
        $stats = [
            'imported' => 0,
            'updated' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        $page = 1;
        $hasMorePages = true;

        while ($hasMorePages) {
            $url = $apiUrl . (str_contains($apiUrl, '?') ? '&' : '?') . "page={$page}";

            try {
                $response = Http::timeout(30)->get($url);

                if (!$response->successful()) {
                    $stats['errors'][] = "Failed to fetch page {$page}: HTTP {$response->status()}";
                    break;
                }

                $data = $response->json();
                $blogs = $data['data'] ?? [];

                if (empty($blogs)) {
                    $hasMorePages = false;
                    continue;
                }

                foreach ($blogs as $apiBlog) {
                    $result = $this->importBlog($apiBlog);

                    if ($result['success']) {
                        if ($result['action'] === 'created') {
                            $stats['imported']++;
                        } else {
                            $stats['updated']++;
                        }
                    } else {
                        $stats['failed']++;
                        $stats['errors'][] = $result['error'];
                    }

                    if ($onProgress) {
                        $onProgress($result, $stats);
                    }
                }

                // Check for next page
                $lastPage = $data['meta']['last_page'] ?? $data['last_page'] ?? null;
                $currentPage = $data['meta']['current_page'] ?? $data['current_page'] ?? $page;

                if ($lastPage !== null && $currentPage >= $lastPage) {
                    $hasMorePages = false;
                } elseif (count($blogs) === 0) {
                    $hasMorePages = false;
                }

                $page++;

            } catch (\Exception $e) {
                $stats['errors'][] = "Page {$page} error: " . $e->getMessage();
                Log::error('Blog import API error', [
                    'page' => $page,
                    'error' => $e->getMessage()
                ]);
                break;
            }
        }

        return $stats;
    }

    /**
     * Import a single blog from API data
     *
     * @param array $apiBlog
     * @return array{success: bool, action: string, error: string|null}
     */
    public function importBlog(array $apiBlog): array
    {
        try {
            return DB::transaction(function () use ($apiBlog) {
                $slug = $apiBlog['slug'] ?? null;

                if (!$slug) {
                    return [
                        'success' => false,
                        'action' => 'skipped',
                        'error' => "Blog has no slug: " . json_encode($apiBlog['id'] ?? 'unknown')
                    ];
                }

                // Find existing blog by slug
                $blog = Blog::withTrashed()->where('slug', $slug)->first();

                $isNew = !$blog;

                if ($isNew) {
                    $blog = new Blog();
                }

                // Map and set blog data
                $blogData = $this->mapBlogData($apiBlog);
                $blog->fill($blogData);

                // Restore if soft deleted
                if ($blog->trashed()) {
                    $blog->restore();
                }

                $blog->save();

                // Handle Media (featured image)
                $this->importBlogMedia($blog, $apiBlog);

                return [
                    'success' => true,
                    'action' => $isNew ? 'created' : 'updated',
                    'error' => null,
                    'blog_id' => $blog->id,
                    'slug' => $blog->slug,
                ];
            });

        } catch (\Exception $e) {
            Log::error('Blog import failed', [
                'api_blog' => $apiBlog['id'] ?? $apiBlog['slug'] ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'action' => 'failed',
                'error' => "Blog " . ($apiBlog['slug'] ?? 'unknown') . ": " . $e->getMessage()
            ];
        }
    }

    /**
     * Map API blog data to database fields
     *
     * @param array $apiBlog
     * @return array
     */
    protected function mapBlogData(array $apiBlog): array
    {
        $title = $apiBlog['title'] ?? '';
        $description = $apiBlog['description'] ?? '';

        // Extract excerpt from description (first 200 chars without HTML)
        $excerpt = Str::limit(strip_tags($description), 200);

        return [
            'slug' => $this->generateUniqueSlug($apiBlog['slug'] ?? Str::slug($title)),
            'is_active' => (bool) ($apiBlog['status'] ?? true),
            'sort_order' => (int) ($apiBlog['sort'] ?? 0),
            'published_at' => $apiBlog['created_at'] ?? now(),
            'author_name' => 'Admin',
            'reading_time' => $this->calculateReadingTime($description),

            // Translatable fields - API doesn't have translations, use same for all locales
            'title' => $this->createTranslations($title),
            'excerpt' => $this->createTranslations($excerpt),
            'body' => $this->createTranslations($description),
            'meta_title' => $this->createTranslations($title),
            'meta_description' => $this->createTranslations($excerpt),
        ];
    }

    /**
     * Create translations array for all locales
     *
     * @param string $value
     * @return array
     */
    protected function createTranslations(string $value): array
    {
        $result = [];
        foreach ($this->locales as $locale) {
            $result[$locale] = $value;
        }
        return $result;
    }

    /**
     * Calculate reading time in minutes
     *
     * @param string $content
     * @return int
     */
    protected function calculateReadingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $readingTime = ceil($wordCount / 200); // Average 200 words per minute
        return max(1, (int) $readingTime);
    }

    /**
     * Generate unique slug
     *
     * @param string $slug
     * @return string
     */
    protected function generateUniqueSlug(string $slug): string
    {
        if (empty($slug)) {
            $slug = Str::random(8);
        }

        $originalSlug = Str::slug($slug);
        $count = 1;
        $newSlug = $originalSlug;

        while (Blog::withTrashed()->where('slug', $newSlug)->exists()) {
            $newSlug = $originalSlug . '-' . $count;
            $count++;
        }

        return $newSlug;
    }

    /**
     * Import blog media (featured image)
     *
     * @param Blog $blog
     * @param array $apiBlog
     * @return void
     */
    protected function importBlogMedia(Blog $blog, array $apiBlog): void
    {
        // Import base image as featured
        if (!empty($apiBlog['base_image']['url'])) {
            // Only import if blog has no featured image yet
            if (!$blog->hasMedia('featured')) {
                $this->importMedia($blog, $apiBlog['base_image']['url'], 'featured');
            }
        }
    }

    /**
     * Import media from URL
     *
     * @param \Spatie\MediaLibrary\HasMedia $model
     * @param string $url
     * @param string $collection
     * @return void
     */
    protected function importMedia($model, string $url, string $collection): void
    {
        try {
            // Skip if URL is invalid
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                return;
            }

            $model->addMediaFromUrl($url)
                ->toMediaCollection($collection);

        } catch (\Exception $e) {
            Log::warning('Failed to import blog media', [
                'url' => $url,
                'collection' => $collection,
                'error' => $e->getMessage()
            ]);
        }
    }
}

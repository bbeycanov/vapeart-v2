<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Services\BlogImportService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportBlogsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int $tries
     */
    public int $tries = 3;

    /**
     * @var int $timeout
     */
    public int $timeout = 1800;

    /**
     * @param string $apiUrl
     * @param string|null $notifyEmail
     */
    public function __construct(
        protected string  $apiUrl,
        protected ?string $notifyEmail = null
    )
    {
    }

    /**
     * @param BlogImportService $importService
     * @return void
     */
    public function handle(BlogImportService $importService): void
    {
        Log::info('Starting blog import job', ['url' => $this->apiUrl]);

        $stats = $importService->importFromApi($this->apiUrl, function ($result, $stats) {
            // Log progress every 10 blogs
            $total = $stats['imported'] + $stats['updated'] + $stats['failed'];
            if ($total % 10 === 0) {
                Log::info('Blog import progress', [
                    'imported' => $stats['imported'],
                    'updated' => $stats['updated'],
                    'failed' => $stats['failed'],
                ]);
            }
        });

        Log::info('Blog import job completed', [
            'imported' => $stats['imported'],
            'updated' => $stats['updated'],
            'failed' => $stats['failed'],
            'errors_count' => count($stats['errors']),
        ]);

        // Log errors for debugging
        if (!empty($stats['errors'])) {
            Log::warning('Blog import errors', [
                'errors' => array_slice($stats['errors'], 0, 20),
            ]);
        }
    }

    /**
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception): void
    {
        Log::error('Blog import job failed', [
            'url' => $this->apiUrl,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}

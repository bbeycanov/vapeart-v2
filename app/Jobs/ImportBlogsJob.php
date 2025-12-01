<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\BlogImportService;

class ImportBlogsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public int $timeout = 1800; // 30 minutes

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $apiUrl,
        protected ?string $notifyEmail = null
    ) {}

    /**
     * Execute the job.
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
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Blog import job failed', [
            'url' => $this->apiUrl,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}

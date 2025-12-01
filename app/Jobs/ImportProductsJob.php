<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\ProductImportService;

class ImportProductsJob implements ShouldQueue
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
    public int $timeout = 3600; // 1 hour

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
    public function handle(ProductImportService $importService): void
    {
        Log::info('Starting product import job', ['url' => $this->apiUrl]);

        $stats = $importService->importFromApi($this->apiUrl, function ($result, $stats) {
            // Log progress every 50 products
            $total = $stats['imported'] + $stats['updated'] + $stats['failed'];
            if ($total % 50 === 0) {
                Log::info('Import progress', [
                    'imported' => $stats['imported'],
                    'updated' => $stats['updated'],
                    'failed' => $stats['failed'],
                ]);
            }
        });

        Log::info('Product import job completed', [
            'imported' => $stats['imported'],
            'updated' => $stats['updated'],
            'failed' => $stats['failed'],
            'errors_count' => count($stats['errors']),
        ]);

        // Log errors for debugging
        if (!empty($stats['errors'])) {
            Log::warning('Product import errors', [
                'errors' => array_slice($stats['errors'], 0, 50),
            ]);
        }

        // Optional: Send notification email
        if ($this->notifyEmail) {
            $this->sendCompletionNotification($stats);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Product import job failed', [
            'url' => $this->apiUrl,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }

    /**
     * Send completion notification
     */
    protected function sendCompletionNotification(array $stats): void
    {
        // TODO: Implement email notification if needed
        // Mail::to($this->notifyEmail)->send(new ImportCompleted($stats));
    }
}

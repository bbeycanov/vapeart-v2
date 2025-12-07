<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Services\ProductImportService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int $tries
     */
    public int $tries = 3;

    /**
     * @var int $timeout
     */
    public int $timeout = 3600;

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
     * @param ProductImportService $importService
     * @return void
     */
    public function handle(ProductImportService $importService): void
    {
        Log::info('Starting product import job', ['url' => $this->apiUrl]);

        $stats = $importService->importFromApi($this->apiUrl, function ($result, $stats) {

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

        if (!empty($stats['errors'])) {
            Log::warning('Product import errors', [
                'errors' => array_slice($stats['errors'], 0, 50),
            ]);
        }

        if ($this->notifyEmail) {
            $this->sendCompletionNotification($stats);
        }
    }

    /**
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception): void
    {
        Log::error('Product import job failed', [
            'url' => $this->apiUrl,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }

    /**
     * @param array $stats
     * @return void
     */
    protected function sendCompletionNotification(array $stats): void
    {
        // TODO: Implement email notification if needed
        // Mail::to($this->notifyEmail)->send(new ImportCompleted($stats));
    }
}

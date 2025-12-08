<?php

namespace App\Jobs;

use App\Services\SitemapGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue('default');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting sitemap generation...');

        try {
            $startTime = microtime(true);

            $generator = new SitemapGenerator();
            $generator->generate();

            $executionTime = round(microtime(true) - $startTime, 2);

            Log::info("Sitemaps generated successfully in {$executionTime} seconds.");
        } catch (\Exception $e) {
            Log::error('Failed to generate sitemaps: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Sitemap generation job failed: ' . $exception->getMessage());
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use App\Services\ElasticsearchService;
use Illuminate\Support\Facades\Log;

class SyncProductsToElasticsearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:sync
                            {--fresh : Delete index and recreate from scratch}
                            {--chunk=100 : Number of products to process per batch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all products from database to Elasticsearch index';

    /**
     * Execute the console command.
     */
    public function handle(ElasticsearchService $elasticsearchService): int
    {
        $this->info('Starting Elasticsearch sync...');
        $this->newLine();

        $chunkSize = (int) $this->option('chunk');
        $isFresh = $this->option('fresh');

        // Fresh sync - delete and recreate index
        if ($isFresh) {
            $this->warn('Fresh sync requested. Deleting existing index...');
            $this->deleteIndex($elasticsearchService);
        }

        // Ensure index exists
        try {
            $elasticsearchService->createIndex();
            $this->info('Index ready.');
        } catch (\Exception $e) {
            $this->error('Failed to create index: ' . $e->getMessage());
            return self::FAILURE;
        }

        // Count total products
        $totalProducts = Product::where('is_active', true)->count();
        $this->info("Found {$totalProducts} active products to sync.");
        $this->newLine();

        if ($totalProducts === 0) {
            $this->warn('No products to sync.');
            return self::SUCCESS;
        }

        // Create progress bar
        $progressBar = $this->output->createProgressBar($totalProducts);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% | %message%');
        $progressBar->setMessage('Starting...');
        $progressBar->start();

        $stats = [
            'synced' => 0,
            'failed' => 0,
            'skipped' => 0,
            'errors' => [],
        ];

        // Process products in chunks
        Product::where('is_active', true)
            ->with(['brand', 'categories', 'tags'])
            ->chunk($chunkSize, function ($products) use ($elasticsearchService, $progressBar, &$stats) {
                foreach ($products as $product) {
                    try {
                        $elasticsearchService->indexProduct($product);
                        $stats['synced']++;
                        $progressBar->setMessage("Synced: {$product->slug}");
                    } catch (\Exception $e) {
                        $stats['failed']++;
                        $errorMsg = "Product {$product->id} ({$product->slug}): " . $e->getMessage();
                        $stats['errors'][] = $errorMsg;
                        Log::error('Elasticsearch sync failed', [
                            'product_id' => $product->id,
                            'error' => $e->getMessage()
                        ]);
                    }
                    $progressBar->advance();
                }
            });

        // Also remove inactive products from index
        $progressBar->setMessage('Cleaning up inactive products...');
        $inactiveProducts = Product::where('is_active', false)->pluck('id');
        foreach ($inactiveProducts as $productId) {
            try {
                $elasticsearchService->deleteProduct($productId);
            } catch (\Exception $e) {
                // Ignore deletion errors
            }
        }

        $progressBar->setMessage('Done!');
        $progressBar->finish();
        $this->newLine(2);

        // Display summary
        $this->info('Sync completed!');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Synced', $stats['synced']],
                ['Failed', $stats['failed']],
                ['Total Processed', $stats['synced'] + $stats['failed']],
            ]
        );

        // Display errors if any
        if (!empty($stats['errors'])) {
            $this->newLine();
            $this->warn('Errors encountered:');
            foreach (array_slice($stats['errors'], 0, 10) as $error) {
                $this->error(" - {$error}");
            }

            if (count($stats['errors']) > 10) {
                $this->warn('... and ' . (count($stats['errors']) - 10) . ' more errors. Check logs for details.');
            }
        }

        Log::info('Elasticsearch sync completed', [
            'synced' => $stats['synced'],
            'failed' => $stats['failed'],
        ]);

        return $stats['failed'] > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Delete the Elasticsearch index
     */
    private function deleteIndex(ElasticsearchService $elasticsearchService): void
    {
        try {
            $reflection = new \ReflectionClass($elasticsearchService);

            $clientProperty = $reflection->getProperty('client');
            $clientProperty->setAccessible(true);
            $client = $clientProperty->getValue($elasticsearchService);

            $indexProperty = $reflection->getProperty('index');
            $indexProperty->setAccessible(true);
            $index = $indexProperty->getValue($elasticsearchService);

            if ($elasticsearchService->indexExists()) {
                $client->indices()->delete(['index' => $index]);
                $this->info("Index '{$index}' deleted.");
            }
        } catch (\Exception $e) {
            $this->warn('Could not delete index: ' . $e->getMessage());
        }
    }
}

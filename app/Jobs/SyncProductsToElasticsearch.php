<?php

namespace App\Jobs;

use Exception;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use App\Services\ElasticsearchService;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SyncProductsToElasticsearch implements ShouldQueue
{
    use Queueable;

    /**
     * @param ElasticsearchService $elasticsearchService
     * @return void
     * @throws Exception
     */
    public function handle(ElasticsearchService $elasticsearchService): void
    {
        try {
            Log::info('Starting Elasticsearch product sync...');

            // Create index if not exists
            $elasticsearchService->createIndex();

            // Sync all active products to Elasticsearch
            Product::where('is_active', true)
                ->with([
                    'brand',
                    'categories',
                    'tags'
                ])
                ->chunk(100, function ($products) use ($elasticsearchService) {
                    foreach ($products as $product) {
                        try {
                            $elasticsearchService->indexProduct($product);
                        } catch (Exception $e) {
                            Log::error("Failed to index product $product->id: " . $e->getMessage());
                        }
                    }
                });

            Log::info('Elasticsearch product sync completed successfully.');
        } catch (Exception $e) {
            Log::error('Elasticsearch product sync failed: ' . $e->getMessage());
            throw $e;
        }
    }
}

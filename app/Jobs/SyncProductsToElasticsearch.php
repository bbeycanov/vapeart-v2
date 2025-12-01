<?php

namespace App\Jobs;

use App\Models\Product;
use App\Services\ElasticsearchService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SyncProductsToElasticsearch implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ElasticsearchService $elasticsearchService): void
    {
        try {
            Log::info('Starting Elasticsearch product sync...');
            
            // Create index if not exists
            $elasticsearchService->createIndex();
            
            // Sync all active products to Elasticsearch
            Product::where('is_active', true)
                ->with(['brand', 'categories', 'tags'])
                ->chunk(100, function ($products) use ($elasticsearchService) {
                    foreach ($products as $product) {
                        try {
                            $elasticsearchService->indexProduct($product);
                        } catch (\Exception $e) {
                            Log::error("Failed to index product {$product->id}: " . $e->getMessage());
                        }
                    }
                });
            
            Log::info('Elasticsearch product sync completed successfully.');
        } catch (\Exception $e) {
            Log::error('Elasticsearch product sync failed: ' . $e->getMessage());
            throw $e;
        }
    }
}

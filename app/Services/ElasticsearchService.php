<?php

namespace App\Services;

use App\Models\Product;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Log;

class ElasticsearchService
{
    protected Client $client;
    protected string $index;

    public function __construct()
    {
        $host = config('scout.elasticsearch.hosts.0.host', env('ELASTICSEARCH_HOST', 'localhost'));
        $port = config('scout.elasticsearch.hosts.0.port', env('ELASTICSEARCH_PORT', 9200));
        $scheme = config('scout.elasticsearch.hosts.0.scheme', env('ELASTICSEARCH_SCHEME', 'http'));
        $user = config('scout.elasticsearch.hosts.0.user', env('ELASTICSEARCH_USER'));
        $pass = config('scout.elasticsearch.hosts.0.pass', env('ELASTICSEARCH_PASS'));

        // Build connection string
        $connectionString = "{$scheme}://";
        if ($user && $pass) {
            $connectionString .= "{$user}:{$pass}@";
        }
        $connectionString .= "{$host}:{$port}";

        $builder = ClientBuilder::create()
            ->setHosts([$connectionString]);

        $this->client = $builder->build();

        $this->index = config('scout.elasticsearch.index', env('ELASTICSEARCH_INDEX', 'vapeart'));
    }

    /**
     * Create index if not exists
     */
    public function createIndex(): void
    {
        if (!$this->indexExists()) {
            $params = [
                'index' => $this->index,
                'body' => [
                    'settings' => [
                        'number_of_shards' => 1,
                        'number_of_replicas' => 0,
                        'analysis' => [
                            'analyzer' => [
                                'custom_analyzer' => [
                                    'type' => 'custom',
                                    'tokenizer' => 'standard',
                                    'filter' => ['lowercase', 'stop']
                                ]
                            ]
                        ]
                    ],
                    'mappings' => [
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'sku' => ['type' => 'keyword'],
                            'slug' => ['type' => 'keyword'],
                            'name' => [
                                'type' => 'text',
                                'analyzer' => 'custom_analyzer',
                                'fields' => [
                                    'keyword' => ['type' => 'keyword']
                                ]
                            ],
                            'name_all_locales' => ['type' => 'text', 'analyzer' => 'custom_analyzer'],
                            'short_description' => ['type' => 'text', 'analyzer' => 'custom_analyzer'],
                            'description' => ['type' => 'text', 'analyzer' => 'custom_analyzer'],
                            'description_all_locales' => ['type' => 'text', 'analyzer' => 'custom_analyzer'],
                            'brand_id' => ['type' => 'integer'],
                            'brand_name' => ['type' => 'text', 'analyzer' => 'custom_analyzer'],
                            'category_ids' => ['type' => 'integer'],
                            'category_names' => ['type' => 'text', 'analyzer' => 'custom_analyzer'],
                            'tag_names' => ['type' => 'text', 'analyzer' => 'custom_analyzer'],
                            'price' => ['type' => 'float'],
                            'currency' => ['type' => 'keyword'],
                            'is_active' => ['type' => 'boolean'],
                            'is_featured' => ['type' => 'boolean'],
                            'is_new' => ['type' => 'boolean'],
                            'is_hot' => ['type' => 'boolean'],
                            'stock_qty' => ['type' => 'integer'],
                            'rating_avg' => ['type' => 'float'],
                            'reviews_count' => ['type' => 'integer'],
                            'image_url' => ['type' => 'keyword'],
                        ]
                    ]
                ]
            ];

            try {
                $this->client->indices()->create($params);
                Log::info("Elasticsearch index '{$this->index}' created successfully.");
            } catch (\Exception $e) {
                Log::error("Failed to create Elasticsearch index: " . $e->getMessage());
                throw $e;
            }
        }
    }

    /**
     * Check if index exists
     */
    public function indexExists(): bool
    {
        try {
            $response = $this->client->indices()->exists(['index' => $this->index]);
            return $response->asBool();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Index a product
     */
    public function indexProduct(Product $product): void
    {
        if (!$product->is_active) {
            $this->deleteProduct($product->id);
            return;
        }

        $this->createIndex();

        $locale = app()->getLocale();
        
        // Get category names in all locales
        $categoryNames = [];
        foreach ($product->categories as $category) {
            $categoryNames[] = $category->getTranslation('name', $locale);
            foreach (['en', 'az', 'ru'] as $loc) {
                $translated = $category->getTranslation('name', $loc);
                if ($translated && !in_array($translated, $categoryNames)) {
                    $categoryNames[] = $translated;
                }
            }
        }
        
        // Get brand name
        $brandName = $product->brand ? $product->brand->getTranslation('name', $locale) : null;
        
        // Get tag names
        $tagNames = [];
        foreach ($product->tags as $tag) {
            $tagNames[] = $tag->getTranslation('name', $locale);
        }

        $body = [
            'id' => $product->id,
            'sku' => $product->sku,
            'slug' => $product->slug,
            'name' => $product->getTranslation('name', $locale),
            'name_all_locales' => is_array($product->name) ? implode(' ', array_values($product->name)) : '',
            'short_description' => $product->getTranslation('short_description', $locale) ?? '',
            'description' => $product->getTranslation('description', $locale) ?? '',
            'description_all_locales' => is_array($product->description) ? implode(' ', array_values($product->description)) : '',
            'brand_id' => $product->brand_id,
            'brand_name' => $brandName ?? '',
            'category_ids' => $product->categories->pluck('id')->toArray(),
            'category_names' => array_filter($categoryNames),
            'tag_names' => array_filter($tagNames),
            'price' => (float)$product->price,
            'currency' => $product->currency ?? 'AZN',
            'is_active' => (bool)$product->is_active,
            'is_featured' => (bool)($product->is_featured ?? false),
            'is_new' => (bool)($product->is_new ?? false),
            'is_hot' => (bool)($product->is_hot ?? false),
            'stock_qty' => $product->stock_qty ?? 0,
            'rating_avg' => (float)($product->rating_avg ?? 0),
            'reviews_count' => $product->reviews_count ?? 0,
            'image_url' => $product->getProductImageUrl('thumb'),
        ];

        $params = [
            'index' => $this->index,
            'id' => $product->id,
            'body' => $body
        ];

        try {
            $this->client->index($params);
        } catch (\Exception $e) {
            Log::error("Failed to index product {$product->id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a product from index
     */
    public function deleteProduct(int $productId): void
    {
        try {
            $params = [
                'index' => $this->index,
                'id' => $productId
            ];
            $this->client->delete($params);
        } catch (\Exception $e) {
            // Ignore if document doesn't exist (404)
            $errorCode = method_exists($e, 'getCode') ? $e->getCode() : 0;
            if ($errorCode !== 404 && !str_contains($e->getMessage(), '404')) {
                Log::error("Failed to delete product {$productId} from index: " . $e->getMessage());
            }
        }
    }

    /**
     * Search products
     */
    public function search(string $query, int $from = 0, int $size = 10): array
    {
        if (empty($query)) {
            return ['hits' => [], 'total' => 0];
        }

        $this->createIndex();

        $params = [
            'index' => $this->index,
            'body' => [
                'from' => $from,
                'size' => $size,
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'multi_match' => [
                                    'query' => $query,
                                    'fields' => [
                                        'name^3',
                                        'name_all_locales^2',
                                        'description^2',
                                        'description_all_locales',
                                        'short_description',
                                        'brand_name^2',
                                        'category_names^2',
                                        'tag_names',
                                        'sku'
                                    ],
                                    'type' => 'best_fields',
                                    'fuzziness' => 'AUTO'
                                ]
                            ]
                        ],
                        'filter' => [
                            ['term' => ['is_active' => true]]
                        ]
                    ]
                ],
                'sort' => [
                    '_score' => ['order' => 'desc'],
                    'is_featured' => ['order' => 'desc'],
                    'rating_avg' => ['order' => 'desc']
                ]
            ]
        ];

        try {
            $response = $this->client->search($params);
            $responseArray = $response->asArray();
            
            return [
                'hits' => $responseArray['hits']['hits'] ?? [],
                'total' => $responseArray['hits']['total']['value'] ?? ($responseArray['hits']['total'] ?? 0)
            ];
        } catch (\Exception $e) {
            Log::error("Elasticsearch search failed: " . $e->getMessage());
            return ['hits' => [], 'total' => 0];
        }
    }

    /**
     * Get product IDs from search results
     */
    public function getProductIds(string $query, int $from = 0, int $size = 10): array
    {
        $results = $this->search($query, $from, $size);
        if (empty($results['hits'])) {
            return [];
        }
        return array_map(fn($hit) => $hit['_source']['id'], $results['hits']);
    }
}


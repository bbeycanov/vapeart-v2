<?php

namespace App\Filament\Resources\Products\Pages;

use Log;
use Exception;
use App\Models\Menu;
use App\Models\Language;
use App\Enums\MenuPosition;
use App\Services\MenuService;
use App\Services\ElasticsearchService;
use Filament\Resources\Pages\CreateRecord;
use Psr\SimpleCache\InvalidArgumentException;
use App\Services\Contracts\ProductServiceInterface;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Concerns\PreservesNonTranslatableData;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateProduct extends CreateRecord
{
    use Translatable, PreservesNonTranslatableData {
        PreservesNonTranslatableData::updatingActiveLocale insteadof Translatable;
        PreservesNonTranslatableData::updatedActiveLocale insteadof Translatable;
    }

    protected static string $resource = ProductResource::class;

    /**
     * Relationship data stored before create
     */
    protected array $relationships = [];

    /**
     * Media data stored before create
     */
    protected array $mediaData = [];

    /**
     * Fields that should be preserved when switching locales
     */
    protected function getNonTranslatableFields(): array
    {
        return [
            'brand_id',
            'categories',
            'tags',
            'price',
            'compare_at_price',
            'currency',
            'is_track_stock',
            'stock_qty',
            'sku',
            'slug',
            'is_new',
            'is_hot',
            'is_featured',
            'featured_menus',
            'sidebar_menus',
            'discounts',
            'is_active',
            'sort_order',
            'thumbnail',
            'images',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }

    protected function beforeCreate(): void
    {
        // Capture form state before any processing
        $formData = $this->form->getState();

        $this->relationships = [
            'categories' => $formData['categories'] ?? [],
            'tags' => $formData['tags'] ?? [],
            'discounts' => $formData['discounts'] ?? [],
            'menus' => array_unique(array_merge(
                $formData['featured_menus'] ?? [],
                $formData['sidebar_menus'] ?? []
            )),
        ];

        // Capture media from $this->data (TemporaryUploadedFile objects)
        $this->mediaData = [
            'thumbnail' => $this->data['thumbnail'] ?? [],
            'images' => $this->data['images'] ?? [],
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove relationship fields - they can't be mass assigned
        unset(
            $data['categories'],
            $data['tags'],
            $data['discounts'],
            $data['featured_menus'],
            $data['sidebar_menus']
        );

        return $data;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function afterCreate(): void
    {
        $this->syncRelationships();
        $this->syncMedia();
        $this->clearProductCache();
        $this->indexToElasticsearch();
    }

    protected function syncMedia(): void
    {
        // Handle thumbnail
        if (!empty($this->mediaData['thumbnail'])) {
            foreach ($this->mediaData['thumbnail'] as $fileData) {
                if ($fileData instanceof TemporaryUploadedFile) {
                    $this->record->addMedia($fileData->getRealPath())
                        ->usingFileName($fileData->getClientOriginalName())
                        ->toMediaCollection('thumbnail');
                }
            }
        }

        // Handle images
        if (!empty($this->mediaData['images'])) {
            foreach ($this->mediaData['images'] as $fileData) {
                if ($fileData instanceof TemporaryUploadedFile) {
                    $this->record->addMedia($fileData->getRealPath())
                        ->usingFileName($fileData->getClientOriginalName())
                        ->toMediaCollection('images');
                }
            }
        }
    }

    protected function syncRelationships(): void
    {
        if (!empty($this->relationships['categories'])) {
            $this->record->categories()->sync($this->relationships['categories']);
        }

        if (!empty($this->relationships['tags'])) {
            $this->record->tags()->sync($this->relationships['tags']);
        }

        if (!empty($this->relationships['discounts'])) {
            $this->record->discounts()->sync($this->relationships['discounts']);
        }

        if (!empty($this->relationships['menus'])) {
            $this->record->menus()->sync($this->relationships['menus']);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function clearProductCache(): void
    {
        app(ProductServiceInterface::class)->flushServiceCache();
        app(MenuService::class)->flushServiceCache();

        $menuIds = Menu::where('position', MenuPosition::FEATURED->value)->pluck('id');
        $locales = Language::pluck('code')->toArray();

        foreach ($menuIds as $menuId) {
            foreach ($locales as $locale) {
                cache()->forget("featured_products_menu_{$menuId}_{$locale}");
            }
        }
    }

    protected function indexToElasticsearch(): void
    {
        try {
            $elasticsearchService = app(ElasticsearchService::class);
            $this->record->load(['brand', 'categories', 'tags']);
            $elasticsearchService->indexProduct($this->record);
        } catch (Exception $e) {
            Log::error('Elasticsearch indexing failed: ' . $e->getMessage());
        }
    }
}

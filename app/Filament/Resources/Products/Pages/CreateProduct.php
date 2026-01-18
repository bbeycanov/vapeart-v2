<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Concerns\PreservesNonTranslatableData;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateProduct extends CreateRecord
{
    use Translatable, PreservesNonTranslatableData {
        PreservesNonTranslatableData::updatingActiveLocale insteadof Translatable;
        PreservesNonTranslatableData::updatedActiveLocale insteadof Translatable;
    }

    protected static string $resource = ProductResource::class;

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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Merge featured_menus and sidebar_menus into menus
        $allMenus = array_merge(
            $data['featured_menus'] ?? [],
            $data['sidebar_menus'] ?? []
        );
        
        $data['menus'] = array_unique($allMenus);
        unset($data['featured_menus'], $data['sidebar_menus']);
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Sync categories relationship
        if (!empty($this->data['categories'])) {
            $this->record->categories()->sync($this->data['categories']);
        }

        // Sync tags relationship
        if (!empty($this->data['tags'])) {
            $this->record->tags()->sync($this->data['tags']);
        }

        // Sync menus relationship (featured_menus merged in mutateFormDataBeforeCreate)
        $allMenus = array_merge(
            $this->data['featured_menus'] ?? [],
            $this->data['sidebar_menus'] ?? []
        );
        if (!empty($allMenus)) {
            $this->record->menus()->sync(array_unique($allMenus));
        }

        // Sync discounts relationship
        if (!empty($this->data['discounts'])) {
            $this->record->discounts()->sync($this->data['discounts']);
        }

        $this->clearCache();

        // Sync to Elasticsearch
        try {
            $elasticsearchService = app(\App\Services\ElasticsearchService::class);
            $this->record->load(['brand', 'categories', 'tags']);
            $elasticsearchService->indexProduct($this->record);
        } catch (\Exception $e) {
            \Log::error('Failed to index product in Elasticsearch: ' . $e->getMessage());
        }
    }

    protected function clearCache(): void
    {
        // Product service cache'ini temizle
        app(\App\Services\Contracts\ProductServiceInterface::class)->flushServiceCache();
        
        // Featured products cache'ini temizle (tüm menüler ve diller için)
        $menus = \App\Models\Menu::where('position', \App\Enums\MenuPosition::FEATURED->value)->pluck('id');
        $locales = \App\Models\Language::pluck('code')->toArray();
        
        foreach ($menus as $menuId) {
            foreach ($locales as $locale) {
                cache()->forget('featured_products_menu_' . $menuId . '_' . $locale);
            }
        }
        
        // Menu service cache'ini temizle
        app(\App\Services\MenuService::class)->flushServiceCache();
    }
}

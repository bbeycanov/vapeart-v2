<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Products\ProductResource;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;

class EditProduct extends EditRecord
{
    use Translatable;

    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Split menus into featured_menus and sidebar_menus
        $menus = $this->record->menus()->get();
        
        $data['featured_menus'] = $menus->filter(function ($menu) {
            return $menu->position === \App\Enums\MenuPosition::FEATURED->value;
        })->pluck('id')->toArray();
        
        $data['sidebar_menus'] = $menus->filter(function ($menu) {
            return $menu->position === \App\Enums\MenuPosition::SIDEBAR->value;
        })->pluck('id')->toArray();
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function afterSave(): void
    {
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

    protected function afterDelete(): void
    {
        $this->clearCache();
        // Remove from Elasticsearch
        try {
            $elasticsearchService = app(\App\Services\ElasticsearchService::class);
            $elasticsearchService->deleteProduct($this->record->id);
        } catch (\Exception $e) {
            \Log::error('Failed to delete product from Elasticsearch: ' . $e->getMessage());
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

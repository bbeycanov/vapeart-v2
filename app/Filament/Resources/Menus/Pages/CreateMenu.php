<?php

namespace App\Filament\Resources\Menus\Pages;

use Illuminate\Support\Facades\Cache;
use App\Filament\Resources\Menus\MenuResource;
use App\Filament\Concerns\PreservesNonTranslatableData;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateMenu extends CreateRecord
{
    use Translatable, PreservesNonTranslatableData {
        PreservesNonTranslatableData::updatingActiveLocale insteadof Translatable;
        PreservesNonTranslatableData::updatedActiveLocale insteadof Translatable;
    }

    protected static string $resource = MenuResource::class;

    protected function getNonTranslatableFields(): array
    {
        return [
            'position',
            'categories',
            'link_url',
            'is_mega_menu',
            'is_active',
            'sort_order',
            'icon',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }

    protected function afterCreate(): void
    {
        // Clear menu cache for all locales
        $locales = \App\Models\Language::query()->pluck('code')->toArray();
        foreach ($locales as $locale) {
            Cache::forget("header_menus:{$locale}");
        }
        // Also clear service cache
        $menuService = app(\App\Services\Contracts\MenuServiceInterface::class);
        if (method_exists($menuService, 'flushServiceCache')) {
            $menuService->flushServiceCache();
        }
    }
}

<?php

namespace App\Filament\Resources\Menus\Pages;

use Illuminate\Support\Facades\Cache;
use App\Filament\Resources\Menus\MenuResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;

class EditMenu extends EditRecord
{
    use Translatable;

    protected static string $resource = MenuResource::class;

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

    protected function afterSave(): void
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

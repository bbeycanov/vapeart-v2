<?php

namespace App\Filament\Resources\Banners\Pages;

use App\Filament\Resources\Banners\BannerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;

class EditBanner extends EditRecord
{
    use Translatable;

    protected static string $resource = BannerResource::class;

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
        $this->clearCache();
    }

    protected function afterDelete(): void
    {
        $this->clearCache();
    }

    protected function clearCache(): void
    {
        // Banner service cache'ini temizle
        $bannerService = app(\App\Services\Contracts\BannerServiceInterface::class);
        if (method_exists($bannerService, 'flushServiceCache')) {
            $bannerService->flushServiceCache();
        }
    }
}

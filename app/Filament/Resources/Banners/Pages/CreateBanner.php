<?php

namespace App\Filament\Resources\Banners\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Banners\BannerResource;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateBanner extends CreateRecord
{
    use Translatable;

    protected static string $resource = BannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }

    protected function afterCreate(): void
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

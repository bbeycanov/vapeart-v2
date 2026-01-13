<?php

namespace App\Filament\Resources\Banners\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Banners\BannerResource;
use App\Filament\Concerns\PreservesNonTranslatableData;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateBanner extends CreateRecord
{
    use Translatable, PreservesNonTranslatableData {
        PreservesNonTranslatableData::updatingActiveLocale insteadof Translatable;
        PreservesNonTranslatableData::updatedActiveLocale insteadof Translatable;
    }

    protected static string $resource = BannerResource::class;

    protected function getNonTranslatableFields(): array
    {
        return [
            'position',
            'type',
            'key',
            'link_url',
            'link_text',
            'target',
            'starts_at',
            'ends_at',
            'is_active',
            'sort_order',
            'desktop',
            'tablet',
            'mobile',
            'video',
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

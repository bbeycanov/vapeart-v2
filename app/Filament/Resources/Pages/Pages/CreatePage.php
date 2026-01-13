<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Filament\Concerns\PreservesNonTranslatableData;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreatePage extends CreateRecord
{
    use Translatable, PreservesNonTranslatableData {
        PreservesNonTranslatableData::updatingActiveLocale insteadof Translatable;
        PreservesNonTranslatableData::updatedActiveLocale insteadof Translatable;
    }

    protected static string $resource = PageResource::class;

    protected function getNonTranslatableFields(): array
    {
        return [
            'slug',
            'is_active',
            'sort_order',
            'gallery',
            'banner_desktop',
            'banner_tablet',
            'banner_mobile',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}

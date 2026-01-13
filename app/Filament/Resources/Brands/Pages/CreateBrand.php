<?php

namespace App\Filament\Resources\Brands\Pages;

use App\Filament\Resources\Brands\BrandResource;
use App\Filament\Concerns\PreservesNonTranslatableData;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateBrand extends CreateRecord
{
    use Translatable, PreservesNonTranslatableData {
        PreservesNonTranslatableData::updatingActiveLocale insteadof Translatable;
        PreservesNonTranslatableData::updatedActiveLocale insteadof Translatable;
    }

    protected static string $resource = BrandResource::class;

    protected function getNonTranslatableFields(): array
    {
        return [
            'slug',
            'website',
            'is_active',
            'is_featured',
            'sort_order',
            'logo',
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

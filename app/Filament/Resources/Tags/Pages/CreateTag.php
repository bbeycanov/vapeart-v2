<?php

namespace App\Filament\Resources\Tags\Pages;

use App\Filament\Resources\Tags\TagResource;
use App\Filament\Concerns\PreservesNonTranslatableData;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateTag extends CreateRecord
{
    use Translatable, PreservesNonTranslatableData {
        PreservesNonTranslatableData::updatingActiveLocale insteadof Translatable;
        PreservesNonTranslatableData::updatedActiveLocale insteadof Translatable;
    }

    protected static string $resource = TagResource::class;

    protected function getNonTranslatableFields(): array
    {
        return [
            'slug',
            'is_active',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}

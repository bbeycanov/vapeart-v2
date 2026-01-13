<?php

namespace App\Filament\Resources\Widgets\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Widgets\WidgetResource;
use App\Filament\Concerns\PreservesNonTranslatableData;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateWidget extends CreateRecord
{
    use Translatable, PreservesNonTranslatableData {
        PreservesNonTranslatableData::updatingActiveLocale insteadof Translatable;
        PreservesNonTranslatableData::updatedActiveLocale insteadof Translatable;
    }

    protected static string $resource = WidgetResource::class;

    protected function getNonTranslatableFields(): array
    {
        return [
            'button_url',
            'is_active',
            'image',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}

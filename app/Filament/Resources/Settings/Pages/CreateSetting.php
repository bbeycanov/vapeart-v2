<?php

namespace App\Filament\Resources\Settings\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Settings\SettingResource;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateSetting extends CreateRecord
{
    use Translatable;

    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}

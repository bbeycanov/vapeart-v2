<?php

namespace App\Filament\Resources\Widgets\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Widgets\WidgetResource;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateWidget extends CreateRecord
{
    use Translatable;

    protected static string $resource = WidgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}

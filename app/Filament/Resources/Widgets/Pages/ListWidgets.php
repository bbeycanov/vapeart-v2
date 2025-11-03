<?php

namespace App\Filament\Resources\Widgets\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Widgets\WidgetResource;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;

class ListWidgets extends ListRecords
{
    use Translatable;

    protected static string $resource = WidgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->button()
                ->label(__('Create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}

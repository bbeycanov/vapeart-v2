<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Products\ProductResource;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;

class ListProducts extends ListRecords
{
    use Translatable;

    protected static string $resource = ProductResource::class;

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

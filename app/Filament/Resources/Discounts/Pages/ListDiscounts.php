<?php

namespace App\Filament\Resources\Discounts\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Discounts\DiscountResource;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;

class ListDiscounts extends ListRecords
{
    use Translatable;

    protected static string $resource = DiscountResource::class;

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

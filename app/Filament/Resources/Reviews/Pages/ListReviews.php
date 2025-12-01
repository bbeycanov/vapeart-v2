<?php

namespace App\Filament\Resources\Reviews\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Reviews\ReviewResource;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

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


<?php

namespace App\Filament\Resources\Discounts\Pages;

use Illuminate\Support\Facades\Cache;
use App\Filament\Resources\Discounts\DiscountResource;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateDiscount extends CreateRecord
{
    use Translatable;

    protected static string $resource = DiscountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }

    protected function afterCreate(): void
    {
        $this->clearDiscountCaches();
    }

    protected function clearDiscountCaches(): void
    {
        // Clear all application cache to ensure fresh product data with discounts
        Cache::flush();
    }
}

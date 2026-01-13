<?php

namespace App\Filament\Resources\Discounts\Pages;

use Illuminate\Support\Facades\Cache;
use App\Filament\Resources\Discounts\DiscountResource;
use App\Filament\Concerns\PreservesNonTranslatableData;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateDiscount extends CreateRecord
{
    use Translatable, PreservesNonTranslatableData {
        PreservesNonTranslatableData::updatingActiveLocale insteadof Translatable;
        PreservesNonTranslatableData::updatedActiveLocale insteadof Translatable;
    }

    protected static string $resource = DiscountResource::class;

    protected function getNonTranslatableFields(): array
    {
        return [
            'code',
            'type',
            'amount',
            'start_date',
            'end_date',
            'usage_limit',
            'used_count',
            'is_active',
            'sort_order',
            'products',
        ];
    }

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

<?php

namespace App\Filament\Resources\Discounts\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Illuminate\Support\Facades\Cache;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Discounts\DiscountResource;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;

class EditDiscount extends EditRecord
{
    use Translatable;

    protected static string $resource = DiscountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->clearDiscountCaches();
    }

    protected function clearDiscountCaches(): void
    {
        // Clear all application cache to ensure fresh product data with discounts
        Cache::flush();
    }
}

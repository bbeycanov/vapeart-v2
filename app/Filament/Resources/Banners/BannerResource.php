<?php

namespace App\Filament\Resources\Banners;

use UnitEnum;
use App\Models\Language;

use BackedEnum;
use App\Models\Banner;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Banners\Pages\EditBanner;
use App\Filament\Resources\Banners\Pages\ListBanners;
use App\Filament\Resources\Banners\Schemas\BannerForm;
use App\Filament\Resources\Banners\Pages\CreateBanner;
use App\Filament\Resources\Banners\Tables\BannersTable;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;


class BannerResource extends Resource
{
    use Translatable;

    public static function getModelLabel(): string
    {
        return __('Banner'); // 'Banner' az.json faylında 'Bannerlər' var, tək halda 'Banner' üçün əmin deyiləm, amma __() işləməlidir.
    }

    public static function getPluralModelLabel(): string
    {
        return __('Banners');
    }


    protected static ?string $model = Banner::class;

    protected static string $routes = 'banners';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Content Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Banners');
    }

    public static function getTitle(): string
    {
        return __('Banners');
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return Heroicon::Link;
    }

    public static function form(Schema $schema): Schema
    {
        return BannerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BannersTable::configure($table);
    }

    public static function getDefaultTranslatableLocale(): string
    {
        return Language::query()->where('is_default', true)->value('code') ?? app()->getLocale();
    }

    public static function getTranslatableLocales(): array
    {
        return Language::query()->orderBy('sort_order')->pluck('code')->toArray() ?? [app()->getLocale()];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBanners::route('/'),
            'create' => CreateBanner::route('/create'),
            'edit' => EditBanner::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }
}

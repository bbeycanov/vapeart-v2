<?php

namespace App\Filament\Resources\Widgets;

use UnitEnum;

use BackedEnum;
use App\Models\Widget;
use App\Models\Language;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Widgets\Pages\EditWidget;
use App\Filament\Resources\Widgets\Pages\ListWidgets;
use App\Filament\Resources\Widgets\Pages\CreateWidget;
use App\Filament\Resources\Widgets\Schemas\WidgetForm;
use App\Filament\Resources\Widgets\Tables\WidgetsTable;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

class WidgetResource extends Resource
{
    use Translatable;

    protected static ?string $model = Widget::class;

    protected static string $routes = 'widgets';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Content Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Widgets');
    }

    public static function getTitle(): string
    {
        return __('Widgets');
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return Heroicon::AcademicCap;
    }

    public static function form(Schema $schema): Schema
    {
        return WidgetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WidgetsTable::configure($table);
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
            'index' => ListWidgets::route('/'),
            'create' => CreateWidget::route('/create'),
            'edit' => EditWidget::route('/{record}/edit'),
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

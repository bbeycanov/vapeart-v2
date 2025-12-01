<?php

namespace App\Filament\Resources\Branches;

use UnitEnum;
use BackedEnum;
use App\Models\Branch;
use App\Models\Language;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Resources\Branches\Pages\EditBranch;
use App\Filament\Resources\Branches\Pages\ListBranches;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Branches\Schemas\BranchForm;
use App\Filament\Resources\Branches\Pages\CreateBranch;
use App\Filament\Resources\Branches\Tables\BranchesTable;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

class BranchResource extends Resource
{
    use Translatable;

    protected static ?string $model = Branch::class;

    protected static string $routes = 'branches';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Content Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Branches');
    }

    public static function getTitle(): string
    {
        return __('Branches');
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return Heroicon::MapPin;
    }

    public static function form(Schema $schema): Schema
    {
        return BranchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BranchesTable::configure($table);
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
            'index' => ListBranches::route('/'),
            'create' => CreateBranch::route('/create'),
            'edit' => EditBranch::route('/{record}/edit'),
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


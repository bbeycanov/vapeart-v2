<?php

namespace App\Filament\Resources\Banners\Tables;

use App\Enums\BannerType;
use Filament\Tables\Table;
use App\Enums\BannerPosition;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class BannersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->pluralModelLabel(__('Banners'))
            ->modelLabel(__('Banner'))
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('image')
                    ->label(__('Image')),
                TextColumn::make('position')
                    ->label(__('Position'))
                    ->formatStateUsing(function ($state) {
                        return BannerPosition::getNames()[$state];
                    })
                    ->searchable(),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->copyable()
                    ->formatStateUsing(function ($state) {
                        return BannerType::getNames()[$state];
                    })
                    ->searchable(),
                TextColumn::make('key')
                    ->label(__('Key'))
                    ->searchable(),
                TextColumn::make('link_url')
                    ->label(__('Link URL'))
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label(__('Active')),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label(__('Deleted At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->button(),
                DeleteAction::make()
                    ->button(),
            ])
            ->headerActions([
                LocaleSwitcher::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }
}

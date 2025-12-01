<?php

namespace App\Filament\Resources\Reviews\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reviewable_type')
                    ->label(__('Type'))
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => class_basename($state))
                    ->sortable(),
                TextColumn::make('reviewable_id')
                    ->label(__('Item ID'))
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('author_name')
                    ->label(__('Author Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('author_email')
                    ->label(__('Author Email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('rating')
                    ->label(__('Rating'))
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn (int $state): string => str_repeat('⭐', $state)),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->limit(50)
                    ->toggleable(),
                TextColumn::make('body')
                    ->label(__('Body'))
                    ->searchable()
                    ->limit(50)
                    ->html()
                    ->toggleable(),
                ToggleColumn::make('status')
                    ->label(__('Approved'))
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label(__('Published at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label(__('Deleted at'))
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
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}


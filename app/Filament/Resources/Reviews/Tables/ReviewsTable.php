<?php

namespace App\Filament\Resources\Reviews\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reviewable_type')
                    ->label(__('Type'))
                    ->formatStateUsing(fn (string $state): string => class_basename($state))
                    ->sortable(),
                TextColumn::make('reviewable_id')
                    ->label(__('Item ID'))
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
                Filter::make('filter')
                    ->schema([
                        Select::make('rating')
                            ->label(__('Rating'))
                            ->options([
                                '5' => '⭐⭐⭐⭐⭐ (5)',
                                '4' => '⭐⭐⭐⭐ (4)',
                                '3' => '⭐⭐⭐ (3)',
                                '2' => '⭐⭐ (2)',
                                '1' => '⭐ (1)',
                            ])
                            ->placeholder(__('All Ratings')),
                        Select::make('status')
                            ->label(__('Approval Status'))
                            ->options([
                                '1' => __('Approved'),
                                '0' => __('Pending'),
                            ])
                            ->placeholder(__('All')),
                        Select::make('reviewable_type')
                            ->label(__('Review Type'))
                            ->options([
                                'App\\Models\\Product' => __('Product'),
                                'App\\Models\\Blog' => __('Blog'),
                            ])
                            ->placeholder(__('All Types')),
                        Select::make('trashed')
                            ->label(__('Deleted Records'))
                            ->options([
                                '' => __('Without Deleted'),
                                'with' => __('With Deleted'),
                                'only' => __('Only Deleted'),
                            ])
                            ->placeholder(__('Without Deleted')),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->query(function (Builder $query, array $data) {
                        // Handle trashed records
                        if (($data['trashed'] ?? '') === 'with') {
                            $query->withTrashed();
                        } elseif (($data['trashed'] ?? '') === 'only') {
                            $query->onlyTrashed();
                        }

                        return $query
                            ->when($data['rating'] ?? null, function (Builder $query, $value) {
                                $query->where('rating', (int) $value);
                            })
                            ->when(isset($data['status']) && $data['status'] !== null && $data['status'] !== '', function (Builder $query) use ($data) {
                                $query->where('status', (bool) $data['status']);
                            })
                            ->when($data['reviewable_type'] ?? null, function (Builder $query, $value) {
                                $query->where('reviewable_type', $value);
                            });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['rating'] ?? null) {
                            $indicators[] = __('Rating') . ': ' . str_repeat('⭐', (int) $data['rating']);
                        }

                        if (isset($data['status']) && $data['status'] !== null && $data['status'] !== '') {
                            $indicators[] = __('Approval Status') . ': ' . ($data['status'] ? __('Approved') : __('Pending'));
                        }

                        if ($data['reviewable_type'] ?? null) {
                            $indicators[] = __('Review Type') . ': ' . class_basename($data['reviewable_type']);
                        }

                        if ($data['trashed'] ?? null) {
                            $trashedLabels = [
                                'with' => __('With Deleted'),
                                'only' => __('Only Deleted'),
                            ];
                            $indicators[] = __('Deleted Records') . ': ' . ($trashedLabels[$data['trashed']] ?? '');
                        }

                        return $indicators;
                    }),
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('2xl')
            ->filtersFormColumns(3)
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


<?php

namespace App\Filament\Resources\Banners\Tables;

use App\Enums\BannerType;
use Filament\Tables\Table;
use App\Enums\BannerPosition;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class BannersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('media'))
            ->pluralModelLabel(__('Banners'))
            ->modelLabel(__('Banner'))
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->numeric()
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('image')
                    ->label(__('Image'))
                    ->conversion('thumb'),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('title', 'like', "%{$search}%");
                    })
                    ->limit(30)
                    ->toggleable(),
                TextColumn::make('position')
                    ->label(__('Position'))
                    ->formatStateUsing(function ($state) {
                        return BannerPosition::getNames()[$state] ?? $state;
                    })
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->copyable()
                    ->formatStateUsing(function ($state) {
                        return BannerType::getNames()[$state] ?? $state;
                    })
                    ->sortable(),
                TextColumn::make('key')
                    ->label(__('Key'))
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label(__('Active')),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Filter::make('filter')
                    ->schema([
                        Select::make('position')
                            ->label(__('Position'))
                            ->searchable()
                            ->preload()
                            ->options(BannerPosition::getNames())
                            ->placeholder(__('All Positions')),
                        Select::make('type')
                            ->label(__('Type'))
                            ->searchable()
                            ->preload()
                            ->options(BannerType::getNames())
                            ->placeholder(__('All Types')),
                        Select::make('is_active')
                            ->label(__('Status'))
                            ->options([
                                '1' => __('Active'),
                                '0' => __('Inactive'),
                            ])
                            ->placeholder(__('All')),
                        Select::make('trashed')
                            ->label(__('Deleted Records'))
                            ->options([
                                'with' => __('With Deleted'),
                                'only' => __('Only Deleted'),
                            ])
                            ->placeholder(__('Without Deleted'))
                            ->native(false),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->query(function (Builder $query, array $data) {
                        // Handle trashed records
                        if (($data['trashed'] ?? '') === 'with') {
                            $query->withTrashed();
                        } elseif (($data['trashed'] ?? '') === 'only') {
                            $query->onlyTrashed();
                        } else {
                            $query->whereNull('deleted_at');
                        }

                        return $query
                            ->when($data['position'] ?? null, function (Builder $query, $value) {
                                $query->where('position', $value);
                            })
                            ->when($data['type'] ?? null, function (Builder $query, $value) {
                                $query->where('type', $value);
                            })
                            ->when(isset($data['is_active']) && $data['is_active'] !== null && $data['is_active'] !== '', function (Builder $query) use ($data) {
                                $query->where('is_active', (bool) $data['is_active']);
                            });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['position'] ?? null) {
                            $indicators[] = __('Position') . ': ' . (BannerPosition::getNames()[$data['position']] ?? $data['position']);
                        }

                        if ($data['type'] ?? null) {
                            $indicators[] = __('Type') . ': ' . (BannerType::getNames()[$data['type']] ?? $data['type']);
                        }

                        if (isset($data['is_active']) && $data['is_active'] !== null && $data['is_active'] !== '') {
                            $indicators[] = __('Status') . ': ' . ($data['is_active'] ? __('Active') : __('Inactive'));
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
                RestoreAction::make()
                    ->button(),
                ForceDeleteAction::make()
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
            ->defaultSort('sort_order')
            ->defaultPaginationPageOption(15);
    }
}

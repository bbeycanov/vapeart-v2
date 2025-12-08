<?php

namespace App\Filament\Resources\Menus\Tables;

use App\Enums\MenuType;
use Filament\Tables\Table;
use App\Enums\MenuPosition;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\ForceDeleteBulkAction;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class MenusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->numeric()
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('image')
                    ->label(__('Image'))
                    ->collection('icon'),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->sortable()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function ($q) use ($search) {
                            $q->where('title', 'like', "%{$search}%")
                              ->orWhere('url', 'like', "%{$search}%");
                        });
                    }),
                TextColumn::make('parent.title')
                    ->label(__('Parent Menu')),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->formatStateUsing(fn($state) => ucfirst(strtolower($state)))
                    ->sortable(),
                TextColumn::make('position')
                    ->label(__('Position'))
                    ->formatStateUsing(fn($state) => ucfirst(strtolower($state)))
                    ->sortable(),
                TextColumn::make('url')
                    ->label(__('URL'))
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label(__('Active')),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable(),
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
                        Select::make('position')
                            ->searchable()
                            ->options(MenuPosition::labels())
                            ->label(__('Position'))
                            ->placeholder(__('All Positions')),
                        Select::make('type')
                            ->searchable()
                            ->options(MenuType::labels())
                            ->label(__('Type'))
                            ->placeholder(__('All Types')),
                        Select::make('parent')
                            ->label(__('Parent Menu'))
                            ->searchable()
                            ->relationship('parent', 'title')
                            ->placeholder(__('All')),
                        Select::make('trashed')
                            ->label(__('Deleted Records'))
                            ->options([
                                '' => __('Without Deleted'),
                                'with' => __('With Deleted'),
                                'only' => __('Only Deleted'),
                            ])
                            ->placeholder(__('Without Deleted')),
                    ])
                    ->columns(4)
                    ->columnSpanFull()
                    ->query(function (Builder $query, array $data) {
                        // Handle trashed records
                        if (($data['trashed'] ?? '') === 'with') {
                            $query->withTrashed();
                        } elseif (($data['trashed'] ?? '') === 'only') {
                            $query->onlyTrashed();
                        }

                        return $query
                            ->when($data['position'] ?? null, function (Builder $query, $value) {
                                $query->where('position', $value);
                            })
                            ->when($data['type'] ?? null, function (Builder $query, $value) {
                                $query->where('type', $value);
                            })
                            ->when($data['parent'] ?? null, function (Builder $query, $value) {
                                $query->where('parent_id', $value);
                            });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['position'] ?? null) {
                            $indicators[] = __('Position') . ': ' . $data['position'];
                        }

                        if ($data['type'] ?? null) {
                            $indicators[] = __('Type') . ': ' . $data['type'];
                        }

                        if ($data['parent'] ?? null) {
                            $indicators[] = __('Parent Menu') . ': ' . $data['parent'];
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

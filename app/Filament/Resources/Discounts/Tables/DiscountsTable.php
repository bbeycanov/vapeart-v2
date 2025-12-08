<?php

namespace App\Filament\Resources\Discounts\Tables;

use App\Enums\DiscountType;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;

class DiscountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('name', 'like', "%{$search}%");
                    }),
                TextColumn::make('code')
                    ->label(__('Code'))
                    ->searchable(),
                TextColumn::make('type')
                    ->label(__('Type')),
                TextColumn::make('amount')
                    ->label(__('Amount'))
                    ->numeric(),
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
                        Select::make('type')
                            ->label(__('Type'))
                            ->searchable()
                            ->options(DiscountType::getNames())
                            ->placeholder(__('All Types')),
                        Select::make('is_active')
                            ->label(__('Status'))
                            ->options([
                                '1' => __('Active'),
                                '0' => __('Inactive'),
                            ])
                            ->placeholder(__('All')),
                        Select::make('validity')
                            ->label(__('Validity'))
                            ->options([
                                'active' => __('Currently Active'),
                                'expired' => __('Expired'),
                                'upcoming' => __('Upcoming'),
                            ])
                            ->placeholder(__('All')),
                        DatePicker::make('start_date_from')
                            ->label(__('Start Date From')),
                        DatePicker::make('end_date_to')
                            ->label(__('End Date To')),
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
                            ->when($data['type'] ?? null, function (Builder $query, $value) {
                                $query->where('type', $value);
                            })
                            ->when(isset($data['is_active']) && $data['is_active'] !== null && $data['is_active'] !== '', function (Builder $query) use ($data) {
                                $query->where('is_active', (bool) $data['is_active']);
                            })
                            ->when($data['validity'] ?? null, function (Builder $query, $value) {
                                $now = now();
                                if ($value === 'active') {
                                    $query->where('is_active', true)
                                        ->where(function ($q) use ($now) {
                                            $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
                                        })
                                        ->where(function ($q) use ($now) {
                                            $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
                                        });
                                } elseif ($value === 'expired') {
                                    $query->whereNotNull('end_date')->where('end_date', '<', $now);
                                } elseif ($value === 'upcoming') {
                                    $query->whereNotNull('start_date')->where('start_date', '>', $now);
                                }
                            })
                            ->when($data['start_date_from'] ?? null, function (Builder $query, $value) {
                                $query->whereDate('start_date', '>=', $value);
                            })
                            ->when($data['end_date_to'] ?? null, function (Builder $query, $value) {
                                $query->whereDate('end_date', '<=', $value);
                            });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['type'] ?? null) {
                            $indicators[] = __('Type') . ': ' . (DiscountType::getNames()[$data['type']] ?? $data['type']);
                        }

                        if (isset($data['is_active']) && $data['is_active'] !== null && $data['is_active'] !== '') {
                            $indicators[] = __('Status') . ': ' . ($data['is_active'] ? __('Active') : __('Inactive'));
                        }

                        if ($data['validity'] ?? null) {
                            $validityLabels = [
                                'active' => __('Currently Active'),
                                'expired' => __('Expired'),
                                'upcoming' => __('Upcoming'),
                            ];
                            $indicators[] = __('Validity') . ': ' . ($validityLabels[$data['validity']] ?? $data['validity']);
                        }

                        if ($data['start_date_from'] ?? null) {
                            $indicators[] = __('Start Date From') . ': ' . $data['start_date_from'];
                        }

                        if ($data['end_date_to'] ?? null) {
                            $indicators[] = __('End Date To') . ': ' . $data['end_date_to'];
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
            ->filtersFormWidth('3xl')
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

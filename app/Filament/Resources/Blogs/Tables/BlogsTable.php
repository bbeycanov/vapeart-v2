<?php

namespace App\Filament\Resources\Blogs\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class BlogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('image')
                    ->label(__('Image'))
                    ->collection('featured'),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function ($q) use ($search) {
                            $q->where('title', 'like', "%{$search}%")
                              ->orWhere('slug', 'like', "%{$search}%");
                        });
                    }),
                TextColumn::make('slug')
                    ->label(__('Slug')),
                TextColumn::make('author_name')
                    ->label(__('Author'))
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label(__('Active')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('filter')
                    ->schema([
                        Select::make('is_active')
                            ->label(__('Status'))
                            ->options([
                                '1' => __('Active'),
                                '0' => __('Inactive'),
                            ])
                            ->placeholder(__('All')),
                        DatePicker::make('created_from')
                            ->label(__('Created From')),
                        DatePicker::make('created_to')
                            ->label(__('Created To')),
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
                            ->when(isset($data['is_active']) && $data['is_active'] !== null && $data['is_active'] !== '', function (Builder $query) use ($data) {
                                $query->where('is_active', (bool) $data['is_active']);
                            })
                            ->when($data['created_from'] ?? null, function (Builder $query, $value) {
                                $query->whereDate('created_at', '>=', $value);
                            })
                            ->when($data['created_to'] ?? null, function (Builder $query, $value) {
                                $query->whereDate('created_at', '<=', $value);
                            });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if (isset($data['is_active']) && $data['is_active'] !== null && $data['is_active'] !== '') {
                            $indicators[] = __('Status') . ': ' . ($data['is_active'] ? __('Active') : __('Inactive'));
                        }

                        if ($data['created_from'] ?? null) {
                            $indicators[] = __('Created From') . ': ' . $data['created_from'];
                        }

                        if ($data['created_to'] ?? null) {
                            $indicators[] = __('Created To') . ': ' . $data['created_to'];
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
            ->defaultSort('sort_order');
    }
}

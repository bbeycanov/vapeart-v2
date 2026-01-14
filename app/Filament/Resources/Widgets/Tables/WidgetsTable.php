<?php

namespace App\Filament\Resources\Widgets\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class WidgetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('media'))
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('image')
                    ->label(__('Image'))
                    ->conversion('thumb'),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function ($q) use ($search) {
                            $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.az')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"])
                              ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.en')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"])
                              ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.ru')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                        });
                    })
                    ->limit(30),
                TextColumn::make('button_text')
                    ->label(__('Button Text')),
                TextColumn::make('button_url')
                    ->label(__('Button URL')),
                ToggleColumn::make('is_active')
                    ->label(__('Active')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
                        Select::make('trashed')
                            ->label(__('Deleted Records'))
                            ->options([
                                'with' => __('With Deleted'),
                                'only' => __('Only Deleted'),
                            ])
                            ->placeholder(__('Without Deleted'))
                            ->native(false),
                    ])
                    ->columns(2)
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
                            });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

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
            ->filtersFormWidth('xl')
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

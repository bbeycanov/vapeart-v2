<?php

namespace App\Filament\Resources\Pages\Tables;

use App\Models\Page;
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

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->sortable()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function ($q) use ($search) {
                            $q->where('title', 'like', "%{$search}%")
                              ->orWhere('slug', 'like', "%{$search}%");
                        });
                    }),
                TextColumn::make('slug')
                    ->label(__('Slug')),
                TextColumn::make('template')
                    ->label(__('Template')),
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
                        Select::make('template')
                            ->label(__('Template'))
                            ->searchable()
                            ->options(fn () => Page::query()->distinct()->pluck('template', 'template')->filter())
                            ->placeholder(__('All Templates')),
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
                            ->when($data['template'] ?? null, function (Builder $query, $value) {
                                $query->where('template', $value);
                            })
                            ->when(isset($data['is_active']) && $data['is_active'] !== null && $data['is_active'] !== '', function (Builder $query) use ($data) {
                                $query->where('is_active', (bool) $data['is_active']);
                            });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['template'] ?? null) {
                            $indicators[] = __('Template') . ': ' . $data['template'];
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
            ->filtersFormWidth('xl')
            ->filtersFormColumns(2)
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

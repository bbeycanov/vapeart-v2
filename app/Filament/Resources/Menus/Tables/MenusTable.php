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
use Filament\Tables\Filters\TrashedFilter;
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
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('image')
                    ->label(__('Image'))
                    ->collection('icon'),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('parent.title')
                    ->label(__('Parent Menu'))
                    ->searchable(),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->formatStateUsing(fn($state) => ucfirst(strtolower($state)))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('position')
                    ->label(__('Position'))
                    ->formatStateUsing(fn($state) => ucfirst(strtolower($state)))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('url')
                    ->label(__('URL'))
                    ->sortable()
                    ->searchable(),
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
                            ->columnSpanFull()
                            ->placeholder(__('Position')),
                        Select::make('type')
                            ->searchable()
                            ->options(MenuType::labels())
                            ->label(__('Type'))
                            ->columnSpanFull()
                            ->placeholder(__('Type')),
                        Select::make('parent')
                            ->label(__('Parent Menu'))
                            ->searchable()
                            ->columnSpanFull()
                            ->relationship('parent', 'title')
                            ->placeholder(__('Parent Menu')),
                    ])
                    ->columns(5)
                    ->columnSpanFull()
                    ->query(function (Builder $query, array $data) {
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

                        return $indicators;
                    }),
                TrashedFilter::make(),
            ], layout: FiltersLayout::Modal)
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

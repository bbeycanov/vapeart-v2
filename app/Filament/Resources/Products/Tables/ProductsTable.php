<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('media'))
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->numeric()
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->label(__('Image'))
                    ->collection('thumbnail')
                    ->conversion('thumb'),
                TextColumn::make('brand.name')
                    ->label(__('Brand'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('brand', function ($q) use ($search) {
                            $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"])
                              ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"])
                              ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.ru')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                        });
                    }),
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function ($q) use ($search) {
                            $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"])
                              ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"])
                              ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.ru')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"])
                              ->orWhereRaw("slug COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"])
                              ->orWhereRaw("sku COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                        });
                    })
                    ->limit(30),
                TextColumn::make('sku')
                    ->label(__('SKU')),
                TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('AZN', true)
                    ->sortable(),
                TextColumn::make('stock_qty')
                    ->label(__('Stock'))
                    ->numeric()
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label(__('Active')),
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
                        Select::make('brand_id')
                            ->label(__('Brand'))
                            ->searchable()
                            ->preload()
                            ->options(fn () => Cache::remember('admin_brands_options', 3600, fn () => Brand::query()->pluck('name', 'id')->toArray()))
                            ->placeholder(__('All Brands')),
                        Select::make('category_id')
                            ->label(__('Category'))
                            ->searchable()
                            ->preload()
                            ->options(fn () => Cache::remember('admin_categories_options', 3600, fn () => Category::query()->pluck('name', 'id')->toArray()))
                            ->placeholder(__('All Categories')),
                        Select::make('is_active')
                            ->label(__('Status'))
                            ->options([
                                '1' => __('Active'),
                                '0' => __('Inactive'),
                            ])
                            ->placeholder(__('All')),
                        Select::make('is_featured')
                            ->label(__('Featured'))
                            ->options([
                                '1' => __('Yes'),
                                '0' => __('No'),
                            ])
                            ->placeholder(__('All')),
                        Select::make('is_new')
                            ->label(__('New'))
                            ->options([
                                '1' => __('Yes'),
                                '0' => __('No'),
                            ])
                            ->placeholder(__('All')),
                        Select::make('is_hot')
                            ->label(__('Hot'))
                            ->options([
                                '1' => __('Yes'),
                                '0' => __('No'),
                            ])
                            ->placeholder(__('All')),
                        Select::make('stock_status')
                            ->label(__('Stock Status'))
                            ->options([
                                'in_stock' => __('In Stock'),
                                'out_of_stock' => __('Out of Stock'),
                            ])
                            ->placeholder(__('All')),
                        TextInput::make('price_from')
                            ->label(__('Price From'))
                            ->numeric()
                            ->prefix('₼')
                            ->placeholder('0'),
                        TextInput::make('price_to')
                            ->label(__('Price To'))
                            ->numeric()
                            ->prefix('₼')
                            ->placeholder('999999'),
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
                            ->when($data['brand_id'] ?? null, function (Builder $query, $value) {
                                $query->where('brand_id', $value);
                            })
                            ->when($data['category_id'] ?? null, function (Builder $query, $value) {
                                $query->whereHas('categories', function ($q) use ($value) {
                                    $q->where('categories.id', $value);
                                });
                            })
                            ->when(isset($data['is_active']) && $data['is_active'] !== null && $data['is_active'] !== '', function (Builder $query) use ($data) {
                                $query->where('is_active', (bool) $data['is_active']);
                            })
                            ->when(isset($data['is_featured']) && $data['is_featured'] !== null && $data['is_featured'] !== '', function (Builder $query) use ($data) {
                                $query->where('is_featured', (bool) $data['is_featured']);
                            })
                            ->when(isset($data['is_new']) && $data['is_new'] !== null && $data['is_new'] !== '', function (Builder $query) use ($data) {
                                $query->where('is_new', (bool) $data['is_new']);
                            })
                            ->when(isset($data['is_hot']) && $data['is_hot'] !== null && $data['is_hot'] !== '', function (Builder $query) use ($data) {
                                $query->where('is_hot', (bool) $data['is_hot']);
                            })
                            ->when($data['stock_status'] ?? null, function (Builder $query, $value) {
                                if ($value === 'in_stock') {
                                    $query->where('stock_qty', '>', 0);
                                } else {
                                    $query->where('stock_qty', '<=', 0);
                                }
                            })
                            ->when($data['price_from'] ?? null, function (Builder $query, $value) {
                                $query->where('price', '>=', $value);
                            })
                            ->when($data['price_to'] ?? null, function (Builder $query, $value) {
                                $query->where('price', '<=', $value);
                            });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['brand_id'] ?? null) {
                            $indicators[] = __('Brand') . ': ' . Brand::find($data['brand_id'])?->name;
                        }

                        if ($data['category_id'] ?? null) {
                            $indicators[] = __('Category') . ': ' . Category::find($data['category_id'])?->name;
                        }

                        if (isset($data['is_active']) && $data['is_active'] !== null && $data['is_active'] !== '') {
                            $indicators[] = __('Status') . ': ' . ($data['is_active'] ? __('Active') : __('Inactive'));
                        }

                        if (isset($data['is_featured']) && $data['is_featured'] !== null && $data['is_featured'] !== '') {
                            $indicators[] = __('Featured') . ': ' . ($data['is_featured'] ? __('Yes') : __('No'));
                        }

                        if (isset($data['is_new']) && $data['is_new'] !== null && $data['is_new'] !== '') {
                            $indicators[] = __('New') . ': ' . ($data['is_new'] ? __('Yes') : __('No'));
                        }

                        if (isset($data['is_hot']) && $data['is_hot'] !== null && $data['is_hot'] !== '') {
                            $indicators[] = __('Hot') . ': ' . ($data['is_hot'] ? __('Yes') : __('No'));
                        }

                        if ($data['stock_status'] ?? null) {
                            $indicators[] = __('Stock Status') . ': ' . ($data['stock_status'] === 'in_stock' ? __('In Stock') : __('Out of Stock'));
                        }

                        if ($data['price_from'] ?? null) {
                            $indicators[] = __('Price From') . ': ' . $data['price_from'];
                        }

                        if ($data['price_to'] ?? null) {
                            $indicators[] = __('Price To') . ': ' . $data['price_to'];
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
            ->filtersFormWidth('4xl')
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
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(15);
    }
}

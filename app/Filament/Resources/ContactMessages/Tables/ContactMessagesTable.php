<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactMessagesTable
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
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('message')
                    ->label(__('Message'))
                    ->limit(50),
                IconColumn::make('is_read')
                    ->label(__('Read'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),
                TextColumn::make('read_at')
                    ->label(__('Read At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                        Select::make('is_read')
                            ->label(__('Read Status'))
                            ->options([
                                '1' => __('Read'),
                                '0' => __('Unread'),
                            ])
                            ->placeholder(__('All')),
                        DatePicker::make('created_from')
                            ->label(__('Created From')),
                        DatePicker::make('created_to')
                            ->label(__('Created To')),
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
                            ->when(isset($data['is_read']) && $data['is_read'] !== null && $data['is_read'] !== '', function (Builder $query) use ($data) {
                                $query->where('is_read', (bool) $data['is_read']);
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

                        if (isset($data['is_read']) && $data['is_read'] !== null && $data['is_read'] !== '') {
                            $indicators[] = __('Read Status') . ': ' . ($data['is_read'] ? __('Read') : __('Unread'));
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
                ViewAction::make(),
                DeleteAction::make(),
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

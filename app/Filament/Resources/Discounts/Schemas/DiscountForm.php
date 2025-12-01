<?php

namespace App\Filament\Resources\Discounts\Schemas;

use App\Models\Language;
use App\Models\Discount;
use App\Enums\DiscountType;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;

class DiscountForm
{
    public static function getDefaultTranslatableLocale(): string
    {
        return Language::query()->where('is_default', true)->value('code') ?? app()->getLocale();
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make('discountTabs')
                    ->tabs([
                        Tabs\Tab::make(__('General'))->schema([
                            Section::make(__('General Information'))
                                ->columns(2)
                                ->collapsible()
                                ->description(__('Define the general information for the category.'))
                                ->schema([
                                    TextInput::make('name')
                                        ->label(__('Name'))
                                        ->live()
                                        ->required(),
                                    TextInput::make('code')
                                        ->label(__('Code'))
                                        ->required(),
                                    Select::make('type')
                                        ->label(__('Type'))
                                        ->options(DiscountType::getNames())
                                        ->required(),
                                    TextInput::make('amount')
                                        ->label(__('Amount'))
                                        ->required(),
                                    DateTimePicker::make('start_date')
                                        ->label(__('Start Date'))
                                        ->required(),
                                    DateTimePicker::make('end_date')
                                        ->label(__('End Date'))
                                        ->required(),
                                    TextInput::make('usage_limit')
                                        ->numeric()
                                        ->label(__('Usage Limit')),
                                    TextInput::make('used_count')
                                        ->numeric()
                                        ->label(__('Used Count')),
                                ]),
                            Section::make(__('Switcher'))
                                ->collapsible()
                                ->description(__('Define the switcher information for the menu item.'))
                                ->schema([
                                    TextInput::make('sort_order')
                                        ->hidden()
                                        ->required()
                                        ->numeric()
                                        ->default(Discount::query()->max('sort_order') + 1),
                                    Toggle::make('is_active')
                                        ->label(__('Is Active'))
                                        ->required(),
                                ]),
                        ]),
                        Tabs\Tab::make(__('Products'))->schema([
                            CheckboxList::make('products')
                                ->label(__('Products'))
                                ->relationship(
                                    name: 'products',
                                    titleAttribute: 'name'
                                )
                                ->searchable()
                                ->columnSpanFull(),
                        ])
                    ])
            ]);
    }
}

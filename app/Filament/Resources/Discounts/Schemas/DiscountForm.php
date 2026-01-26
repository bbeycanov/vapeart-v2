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
                                        ->required()
                                        ->validationMessages([
                                            'required' => __('admin.validation.required'),
                                        ]),
                                    TextInput::make('code')
                                        ->label(__('Code'))
                                        ->required()
                                        ->validationMessages([
                                            'required' => __('admin.validation.required'),
                                        ]),
                                    Select::make('type')
                                        ->label(__('Type'))
                                        ->options(DiscountType::getNames())
                                        ->required()
                                        ->validationMessages([
                                            'required' => __('admin.validation.required'),
                                        ]),
                                    TextInput::make('amount')
                                        ->label(__('Amount'))
                                        ->required()
                                        ->validationMessages([
                                            'required' => __('admin.validation.required'),
                                        ]),
                                    DateTimePicker::make('start_date')
                                        ->label(__('Start Date'))
                                        ->required()
                                        ->validationMessages([
                                            'required' => __('admin.validation.required'),
                                        ]),
                                    DateTimePicker::make('end_date')
                                        ->label(__('End Date'))
                                        ->required()
                                        ->validationMessages([
                                            'required' => __('admin.validation.required'),
                                        ]),
                                    TextInput::make('usage_limit')
                                        ->numeric()
                                        ->label(__('Usage Limit'))
                                        ->validationMessages([
                                            'numeric' => __('admin.validation.numeric'),
                                        ]),
                                    TextInput::make('used_count')
                                        ->numeric()
                                        ->default(0)
                                        ->label(__('Used Count'))
                                        ->validationMessages([
                                            'numeric' => __('admin.validation.numeric'),
                                        ]),
                                ]),
                            Section::make(__('Switcher'))
                                ->collapsible()
                                ->description(__('Define the switcher information for the menu item.'))
                                ->schema([
                                    TextInput::make('sort_order')
                                        ->hidden()
                                        ->required()
                                        ->numeric()
                                        ->default(Discount::query()->max('sort_order') + 1)
                                        ->validationMessages([
                                            'required' => __('admin.validation.required'),
                                            'numeric' => __('admin.validation.numeric'),
                                        ]),
                                    Toggle::make('is_active')
                                        ->label(__('Is Active'))
                                        ->required(),
                                    Toggle::make('is_show_home_page')
                                        ->label(__('Show on Home Page'))
                                        ->helperText(__('When enabled, products from this discount will be shown in the homepage discounts section.'))
                                        ->default(false),
                                ]),
                        ]),
                        Tabs\Tab::make(__('Products'))->schema([
                            Select::make('products')
                                ->label(__('Products'))
                                ->relationship(
                                    name: 'products',
                                    titleAttribute: 'name'
                                )
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', app()->getLocale()) ?: $record->name)
                                ->searchable()
                                ->multiple()
                                ->preload()
                                ->getSearchResultsUsing(function (string $search) {
                                    return \App\Models\Product::query()
                                        ->where(function ($query) use ($search) {
                                            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"])
                                                ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"])
                                                ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.ru')) COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                                        })
                                        ->orderBy('name')
                                        ->limit(50)
                                        ->get()
                                        ->mapWithKeys(fn ($product) => [$product->id => $product->getTranslation('name', app()->getLocale()) ?: $product->name])
                                        ->toArray();
                                })
                                ->columnSpanFull(),
                        ])
                    ])
            ]);
    }
}

<?php

namespace App\Filament\Resources\Settings\Schemas;

use App\Models\Setting;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('General Information'))
                    ->columns(1)
                    ->collapsible()
                    ->description(__('Define the general information for the category.'))
                    ->schema([
                        TextInput::make('key')
                            ->label(__('Key'))
                            ->live()
                            ->columnSpanFull()
                            ->required()
                            ->validationMessages([
                                'required' => __('admin.validation.required'),
                            ]),
                        TextInput::make('value')
                            ->label(__('Value'))
                            ->columnSpanFull()
                            ->required()
                            ->validationMessages([
                                'required' => __('admin.validation.required'),
                            ]),
                    ]),

                Section::make(__('Switcher'))
                    ->columns(6)
                    ->collapsible()
                    ->description(__('Define the switcher information for the menu item.'))
                    ->schema([
                        Toggle::make('is_public')
                            ->label(__('Is Public')),
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->required(),
                        TextInput::make('sort_order')
                            ->hidden()
                            ->required()
                            ->numeric()
                            ->default(Setting::query()->max('sort_order') + 1)
                            ->validationMessages([
                                'required' => __('admin.validation.required'),
                                'numeric' => __('admin.validation.numeric'),
                            ]),
                    ]),
            ]);
    }
}

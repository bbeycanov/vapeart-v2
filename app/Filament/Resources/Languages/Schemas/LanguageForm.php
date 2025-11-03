<?php

namespace App\Filament\Resources\Languages\Schemas;

use App\Models\Language;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class LanguageForm
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
                        TextInput::make('code')
                            ->label(__('Language Code'))
                            ->regex('/^[a-z]{2}$/i')
                            ->maxLength(2)
                            ->required(),
                        TextInput::make('name')
                            ->label(__('Language Name'))
                            ->required(),
                        TextInput::make('native_name')
                            ->label(__('Native Name'))
                            ->required(),
                    ]),
                Section::make(__('Switcher'))
                    ->collapsible()
                    ->columns(6)
                    ->description(__('Define the switcher information for the menu item.'))
                    ->schema([
                        TextInput::make('sort_order')
                            ->hidden()
                            ->required()
                            ->numeric()
                            ->default(Language::query()->max('sort_order') + 1),
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->required(),
                        Toggle::make('is_default')
                            ->label(__('Is Default'))
                    ]),
            ]);
    }
}

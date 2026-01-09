<?php

namespace App\Filament\Resources\Tags\Schemas;

use App\Models\Language;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;

class TagForm
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
                Section::make(__('General Information'))
                    ->columns(1)
                    ->collapsible()
                    ->description(__('Define the general information for the category.'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->live(onBlur: true)
                            ->columnSpanFull()
                            ->required()
                            ->afterStateUpdated(function ($state, Set $set, $livewire) {
                                // Only generate slug when in English locale
                                if ($livewire->activeLocale === 'en') {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('slug')
                            ->label(__('Slug'))
                            ->columnSpanFull()
                            ->dehydrated()
                            ->readonly(),
                    ]),
                Section::make(__('Switcher'))
                    ->collapsible()
                    ->description(__('Define the switcher information for the menu item.'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->required(),
                    ]),
            ]);
    }
}

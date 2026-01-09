<?php

namespace App\Filament\Resources\Branches\Schemas;

use App\Models\Language;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use App\Enums\RichEditorFullToolBarButton;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;

class BranchForm
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
                    ->columns(2)
                    ->collapsible()
                    ->description(__('Define the general information for the branch.'))
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
                        Textarea::make('address')
                            ->label(__('Address'))
                            ->columnSpanFull()
                            ->rows(3),
                        TextInput::make('phone')
                            ->label(__('Phone'))
                            ->tel(),
                        TextInput::make('email')
                            ->label(__('Email'))
                            ->email(),
                        TextInput::make('whatsapp')
                            ->label(__('WhatsApp'))
                            ->tel()
                            ->helperText(__('WhatsApp number with country code (e.g., 994501234567)')),
                        RichEditor::make('description')
                            ->label(__('Description'))
                            ->toolbarButtons(RichEditorFullToolBarButton::getAll())
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Working Hours'))
                    ->columns(1)
                    ->collapsible()
                    ->description(__('Define the working hours for the branch.'))
                    ->schema([
                        Textarea::make('working_hours')
                            ->label(__('Working Hours'))
                            ->helperText(__('Example: Monday-Friday: 09:00-18:00, Saturday: 10:00-16:00'))
                            ->rows(4),
                    ]),

                Section::make(__('Location'))
                    ->columns(2)
                    ->collapsible()
                    ->description(__('Define the location coordinates for the branch.'))
                    ->schema([
                        TextInput::make('latitude')
                            ->label(__('Latitude'))
                            ->numeric()
                            ->step(0.00000001)
                            ->helperText(__('Map latitude coordinate')),
                        TextInput::make('longitude')
                            ->label(__('Longitude'))
                            ->numeric()
                            ->step(0.00000001)
                            ->helperText(__('Map longitude coordinate')),
                    ]),

                Section::make(__('SEO Information'))
                    ->columns(1)
                    ->collapsible()
                    ->description(__('Define the SEO information for the branch.'))
                    ->schema([
                        TextInput::make('slug')
                            ->label(__('Slug'))
                            ->columnSpanFull()
                            ->dehydrated()
                            ->readonly(),
                        TextInput::make('meta_title')
                            ->label(__('Meta Title')),
                        Textarea::make('meta_description')
                            ->label(__('Meta Description')),
                    ]),

                Section::make(__('Switcher'))
                    ->collapsible()
                    ->description(__('Define the switcher information for the branch.'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->required(),
                        Toggle::make('is_default')
                            ->label(__('Is Default'))
                            ->helperText(__('Set as default branch for contact page'))
                            ->afterStateUpdated(function ($state, Set $set, $livewire) {
                                // If setting this branch as default, unset others
                                if ($state) {
                                    \App\Models\Branch::where('id', '!=', $livewire->record?->id)
                                        ->update(['is_default' => false]);
                                }
                            }),
                    ]),
            ]);
    }
}


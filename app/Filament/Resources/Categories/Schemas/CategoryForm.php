<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Language;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use App\Enums\RichEditorFullToolBarButton;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class CategoryForm
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
                        Select::make('parent_id')
                            ->label(__('Parent Menu'))
                            ->relationship('parent', 'name'),
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->live()
                            ->columnSpanFull()
                            ->required()
                            ->afterStateUpdated(function ($state, Set $set, Get $get, $livewire) {
                                if ($livewire->activeLocale == self::getDefaultTranslatableLocale()) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        RichEditor::make('description')
                            ->label(__('Content'))
                            ->toolbarButtons(RichEditorFullToolBarButton::getAll())
                            ->columnSpanFull(),
                    ]),
                Section::make(__('SEO Information'))
                    ->columns(1)
                    ->collapsible()
                    ->description(__('Define the SEO information for the menu item.'))
                    ->schema([
                        TextInput::make('slug')
                            ->label(__('Slug'))
                            ->columnSpanFull()
                            ->required()
                            ->readonly(),
                        TextInput::make('meta_title')
                            ->label(__('Meta Title')),
                        Textarea::make('meta_description')
                            ->label(__('Meta Description')),
                    ]),
                Section::make(__('Media'))
                    ->columns()
                    ->collapsible()
                    ->description(__('Define the media information for the menu item.'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('icon')
                            ->image()
                            ->label(__('Icon'))
                            ->disk(config('filesystems.default'))
                            ->collection('icon')
                            ->imagePreviewHeight('250')
                            ->helperText(__('Recommended size: 1200x600px, Max size: 1MB')),
                        SpatieMediaLibraryFileUpload::make('banner')
                            ->image()
                            ->label(__('Banner Image'))
                            ->disk(config('filesystems.default'))
                            ->collection('banner')
                            ->imagePreviewHeight('250')
                            ->helperText(__('Recommended size: 1200x600px, Max size: 1MB')),
                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->label(__('Gallery Images'))
                            ->disk(config('filesystems.default'))
                            ->collection('gallery')
                            ->imagePreviewHeight('250')
                            ->columnSpanFull()
                            ->helperText(__('You can upload multiple images. Max size per image: 5MB'))
                            ->multiple(),
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

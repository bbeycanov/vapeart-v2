<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Models\Language;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use App\Enums\RichEditorFullToolBarButton;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PageForm
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
                    ->description(__('Enter general information for the page'))
                    ->schema([
                        TextInput::make('template')
                            ->label(__('Template'))
                            ->required()
                            ->columnSpanFull()
                            ->readOnly()
                            ->default('default'),
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->live()
                            ->columnSpanFull()
                            ->required()
                            ->afterStateUpdated(function ($state, Set $set, Get $get, $livewire) {
                                if ($livewire->activeLocale == self::getDefaultTranslatableLocale()) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('excerpt')
                            ->columnSpanFull()
                            ->label(__('Excerpt')),
                        RichEditor::make('body')
                            ->label(__('Content'))
                            ->toolbarButtons(RichEditorFullToolBarButton::getAll())
                            ->columnSpanFull(),
                    ]),
                Section::make(__('Seo Information'))
                    ->columns(1)
                    ->collapsible()
                    ->description(__('Enter seo information for the page'))
                    ->schema([
                        TextInput::make('slug')
                            ->label(__('Slug'))
                            ->columnSpanFull()
                            ->required()
                            ->readonly(),
                        TextInput::make('meta_title'),
                        TextInput::make('meta_description'),
                    ]),

                Section::make(__('Image & Media'))
                    ->columns(2)
                    ->collapsible()
                    ->description(__('Upload images and media for the banner'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('featured')
                            ->image()
                            ->label(__('Featured Image'))
                            ->disk(config('filesystems.default'))
                            ->collection('featured')
                            ->imagePreviewHeight('250')
                            ->helperText(__('Recommended size: 1200x600px, Max size: 1MB')),
                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->label(__('Gallery Images'))
                            ->disk(config('filesystems.default'))
                            ->collection('gallery')
                            ->imagePreviewHeight('250')
                            ->helperText(__('You can upload multiple images. Max size per image: 5MB'))
                            ->multiple(),
                    ]),

                Section::make(__('Status'))
                    ->columns()
                    ->collapsible()
                    ->description(__('Set the status and settings for the blog post'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->default(true),
                    ]),
            ]);
    }
}

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
                            ->live(onBlur: true)
                            ->columnSpanFull()
                            ->required()
                            ->afterStateUpdated(function ($state, Set $set, $livewire) {
                                if ($livewire->activeLocale === 'en') {
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
                    ->columns(3)
                    ->collapsible()
                    ->description(__('Upload images and media for the banner'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->label(__('Gallery Images'))
                            ->disk(config('filesystems.default'))
                            ->collection('gallery')
                            ->imagePreviewHeight('250')
                            ->columnSpanFull()
                            ->helperText(__('You can upload multiple images. Max size per image: 5MB'))
                            ->multiple(),
                        SpatieMediaLibraryFileUpload::make('banner_desktop')
                            ->image()
                            ->label(__('Banner Desktop Image'))
                            ->disk(config('filesystems.default'))
                            ->collection('banner_desktop')
                            ->imagePreviewHeight('250')
                            ->helperText(__('Recommended size: 1920x600px, Max size: 2MB')),
                        SpatieMediaLibraryFileUpload::make('banner_tablet')
                            ->image()
                            ->label(__('Banner Tablet Image'))
                            ->disk(config('filesystems.default'))
                            ->collection('banner_tablet')
                            ->imagePreviewHeight('250')
                            ->helperText(__('Recommended size: 800x600px, Max size: 1MB')),
                        SpatieMediaLibraryFileUpload::make('banner_mobile')
                            ->image()
                            ->label(__('Banner Mobile Image'))
                            ->disk(config('filesystems.default'))
                            ->collection('banner_mobile')
                            ->imagePreviewHeight('250')
                            ->helperText(__('Recommended size: 400x600px, Max size: 1MB')),
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

<?php

namespace App\Filament\Resources\Blogs\Schemas;

use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DatePicker;
use App\Enums\RichEditorFullToolBarButton;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class BlogForm
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
                Grid::make(1)
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Section::make(__('General Information'))
                                    ->columns(2)
                                    ->collapsible()
                                    ->description(__('Enter general information for the blog post'))
                                    ->schema([
                                        TextInput::make('slug')
                                            ->label(__('Slug'))
                                            ->columnSpanFull()
                                            ->required()
                                            ->readonly(),
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
                                        RichEditor::make('excerpt')
                                            ->label(__('Excerpt'))
                                            ->toolbarButtons(RichEditorFullToolBarButton::getAll())
                                            ->columnSpanFull()
                                            ->helperText(__('Short summary of the blog post')),
                                        RichEditor::make('body')
                                            ->label(__('Content'))
                                            ->toolbarButtons(RichEditorFullToolBarButton::getAll())
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Grid::make()
                            ->schema([
                                Section::make(__('SEO & Meta'))
                                    ->columns(1)
                                    ->collapsible()
                                    ->description(__('Enter SEO and meta information for the blog post'))
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label(__('Meta title'))
                                            ->columnSpanFull(),
                                        TextInput::make('meta_description')
                                            ->label(__('Meta description'))
                                            ->columnSpanFull(),
                                    ]),
                                Section::make(__('Settings'))
                                    ->columns(3)
                                    ->collapsible()
                                    ->description(__('Additional settings for the blog post'))
                                    ->schema([

                                        Select::make('author_name')
                                            ->label(__('Author Name'))
                                            ->searchable()
                                            ->live()
                                            ->options(User::whereNotNull('name')->pluck('name', 'name')->toArray())
                                            ->default(auth()->user()?->name ?? __('Admin')),

                                        DatePicker::make('published_at')
                                            ->label(__('Published At')),

                                        TextInput::make('reading_time')
                                            ->label(__('Reading Time (minutes)'))
                                            ->numeric()
                                            ->readOnly()
                                            ->columnSpanFull()
                                            ->minValue(1),
                                    ]),
                            ]),
                    ]),
                Grid::make()
                    ->schema([
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
                            ->columns(2)
                            ->collapsible()
                            ->description(__('Set the status and settings for the blog post'))
                            ->schema([
                                Select::make('status')
                                    ->label(__('Status'))
                                    ->options([
                                        0 => __('Draft'),
                                        1 => __('Published'),
                                    ])
                                    ->default(0)
                                    ->required(),
                                Toggle::make('is_active')
                                    ->label(__('Is Active'))
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }
}

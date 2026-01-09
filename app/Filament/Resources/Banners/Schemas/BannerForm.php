<?php

namespace App\Filament\Resources\Banners\Schemas;

use App\Models\Banner;
use App\Enums\BannerType;
use Filament\Schemas\Schema;
use App\Enums\BannerPosition;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use App\Enums\RichEditorFullToolBarButton;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('Position & Type'))
                    ->columns()
                    ->collapsible()
                    ->description(__('Select banner position and type'))
                    ->schema([
                        Select::make('position')
                            ->required()
                            ->label(__('Position'))
                            ->options(BannerPosition::getNames())
                            ->default(BannerPosition::HOME_HERO_SLIDESHOW->value),
                        Select::make('type')
                            ->required()
                            ->label(__('Type'))
                            ->options(BannerType::getNames())
                            ->default(BannerType::IMAGE->value),
                    ]),
                Section::make(__('General Information'))
                    ->columns(1)
                    ->collapsible()
                    ->description(__('Enter general information for the banner'))
                    ->schema([
                        TextInput::make('key')
                            ->columnSpanFull()
                            ->required(),
                        Group::make([
                            TextInput::make('title')
                                ->placeholder(__('Big Sale')),
                            TextInput::make('subtitle')
                                ->placeholder(__('Up to 50% Off'))
                        ])->columns(),
                        Group::make([
                            Textarea::make('content')
                                ->placeholder(__('Your promotional content goes here...'))
                                ->rows(3),
                            RichEditor::make('html')
                                ->placeholder('<p>Your custom HTML content goes here...</p>')
                                ->toolbarButtons(RichEditorFullToolBarButton::getAll())
                        ]),
                        Group::make([
                            TextInput::make('link_text')
                                ->placeholder(__('Click Here')),
                            TextInput::make('link_url')
                                ->placeholder('https://example.com'),
                            Select::make('target')
                                ->options([
                                    '_self' => 'Self',
                                    '_blank' => 'Blank',
                                ])->default('_self'),
                        ])->columns(3)
                    ]),

                Section::make(__('Image & Media'))
                    ->columns(2)
                    ->collapsible()
                    ->description(__('Upload images and media for the banner'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('desktop')
                            ->image()
                            ->label(__('Desktop Image'))
                            ->disk(config('filesystems.default'))
                            ->collection('desktop')
                            ->imagePreviewHeight('250')
                            ->helperText(__('Recommended size: 1920x600px, Max size: 2MB')),
                        SpatieMediaLibraryFileUpload::make('tablet')
                            ->image()
                            ->label(__('Tablet'))
                            ->disk(config('filesystems.default'))
                            ->collection('tablet')
                            ->imagePreviewHeight('250')
                            ->helperText(__('Recommended size: 800x600px, Max size: 1MB')),
                        SpatieMediaLibraryFileUpload::make('mobile')
                            ->image()
                            ->label(__('Mobile'))
                            ->disk(config('filesystems.default'))
                            ->collection('mobile')
                            ->imagePreviewHeight('250')
                            ->helperText(__('Recommended size: 400x600px, Max size: 1MB')),
                        SpatieMediaLibraryFileUpload::make('video')
                            ->label(__('Video'))
                            ->disk(config('filesystems.default'))
                            ->collection('video')
                            ->imagePreviewHeight('250')
                            ->helperText('Max size: 15MB'),
                    ]),

                Section::make(__('Schedule'))
                    ->columns()
                    ->collapsible()
                    ->description(__('Set start and end time for banner visibility'))
                    ->schema([
                        DateTimePicker::make('starts_at'),
                        DateTimePicker::make('ends_at'),
                    ]),

                Section::make(__('Switches'))
                    ->columns(1)
                    ->collapsible()
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('Active'))
                            ->required(),
                    ]),

                TextInput::make('sort_order')
                    ->required()
                    ->hidden()
                    ->numeric()
                    ->default(function () {
                        return Banner::max('sort_order') + 1;
                    }),
            ]);
    }
}

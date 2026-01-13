<?php

namespace App\Filament\Resources\Widgets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Kahusoftware\FilamentCkeditorField\CKEditor;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class WidgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('General Information'))
                    ->columns(2)
                    ->collapsible()
                    ->description(__('Enter general information for the widget'))
                    ->schema([
                        TextInput::make('title')
                            ->columnSpanFull()
                            ->label(__('Title')),
                        CKEditor::make('content')
                            ->columnSpanFull()
                            ->placeholder('<p>Your custom HTML content goes here...</p>')
                            ->uploadUrl(route('admin.ckeditor.upload')),
                        TextInput::make('button_text')
                            ->label(__('Button Text')),
                        TextInput::make('button_url')
                            ->label(__('Button URL'))
                    ]),

                Section::make(__('Image & Media'))
                    ->columns(1)
                    ->collapsible()
                    ->description(__('Upload images and media for the banner'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->image()
                            ->label(__('Image'))
                            ->disk(config('filesystems.default'))
                            ->collection('image')
                            ->imagePreviewHeight('250')
                            ->helperText(__('Recommended size: 1200x600px, Max size: 1MB')),
                    ]),

                Section::make(__('Switches'))
                    ->columns(1)
                    ->collapsible()
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('Active'))
                            ->required(),
                    ]),
            ]);
    }
}

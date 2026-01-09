<?php

namespace App\Filament\Resources\Brands\Schemas;

use App\Models\Language;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use App\Enums\RichEditorFullToolBarButton;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class BrandForm
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
                        TextInput::make('website')
                            ->label(__('Website'))
                            ->columnSpanFull()
                            ->url(),
                        RichEditor::make('description')
                            ->label(__('Content'))
                            ->toolbarButtons(RichEditorFullToolBarButton::getAll())
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Social Links'))
                    ->columns(1)
                    ->collapsible()
                    ->description(__('Define the social links for the menu item.'))
                    ->schema([
                        KeyValue::make('social_links')
                            ->label(__('Social Links'))
                            ->keyLabel(__('Platform'))
                            ->valueLabel(__('URL'))
                            ->columns(1)
                            ->editableKeys(false)
                            ->addable(false)
                            ->deleteAction(fn (Action $action) => $action->icon('heroicon-m-trash'))
                            ->afterStateHydrated(function (KeyValue $component, $state) {
                                if (blank($state)) {
                                    $component->state([
                                        'facebook'  => 'https://facebook.com/',
                                        'twitter'   => 'https://twitter.com/',
                                        'instagram' => 'https://instagram.com/',
                                        'linkedin'  => 'https://linkedin.com/',
                                        'youtube'   => 'https://youtube.com/',
                                    ]);
                                }
                            })
                    ]),

                Section::make(__('SEO Information'))
                    ->columns(1)
                    ->collapsible()
                    ->description(__('Define the SEO information for the menu item.'))
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

                Section::make(__('Media'))
                    ->columns()
                    ->collapsible()
                    ->description(__('Define the media information for the menu item.'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->image()
                            ->label(__('Logo'))
                            ->disk(config('filesystems.default'))
                            ->collection('logo')
                            ->imagePreviewHeight('250')
                            ->helperText(__('Recommended size: 1200x600px, Max size: 1MB')),
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

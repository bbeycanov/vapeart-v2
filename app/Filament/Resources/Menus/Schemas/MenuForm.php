<?php

namespace App\Filament\Resources\Menus\Schemas;

use App\Models\Menu;
use App\Models\Widget;
use App\Enums\MenuType;
use App\Enums\UrlTarget;
use App\Enums\MenuPosition;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('Position and Type'))
                    ->columns()
                    ->collapsible()
                    ->description(__('Define the general information for the menu item.'))
                    ->schema([
                        Select::make('position')
                            ->label(__('Position'))
                            ->required()
                            ->live()
                            ->options(MenuPosition::labels())
                            ->afterStateUpdated(fn(Set $set) => $set('parent_id', null))
                            ->validationMessages([
                                'required' => __('admin.validation.required'),
                            ]),

                        Select::make('type')
                            ->label(__('Type'))
                            ->required()
                            ->live()
                            ->options(MenuType::labels())
                            ->validationMessages([
                                'required' => __('admin.validation.required'),
                            ]),

                        Select::make('parent_id')
                            ->label(__('Parent Menu'))
                            ->options(function (Get $get) {
                                $position = $get('position');
                                if (!$position) {
                                    return [];
                                }

                                return Menu::query()
                                    ->where('position', $position)
                                    ->pluck('title', 'id')
                                    ->toArray();
                            })
                            ->columnSpanFull()
                            ->reactive(),
                        Select::make('widgets')
                            ->label(__('Widgets'))
                            ->multiple()
                            ->relationship(
                                name: 'widgets',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn(Builder $query) => $query
                                    ->where('is_active', true)
                                    ->orderBy('sort_order')
                            )
                            ->getOptionLabelFromRecordUsing(function (Widget $record): string {
                                $locale = app()->getLocale();

                                $title = $record->getTranslation('title', $locale, false);
                                if (is_string($title) && $title !== '') {
                                    return $title;
                                }

                                if (is_array($record->title) && !empty($record->title)) {
                                    return (string)reset($record->title);
                                }

                                return 'Widget #' . $record->id;
                            })
                            ->preload()
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search) {
                                $searchLower = mb_strtolower($search);
                                return Widget::query()
                                    ->where('is_active', true)
                                    ->where(function ($query) use ($searchLower) {
                                        $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(title, '$.az'))) LIKE ?", ["%{$searchLower}%"])
                                            ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(title, '$.en'))) LIKE ?", ["%{$searchLower}%"])
                                            ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(title, '$.ru'))) LIKE ?", ["%{$searchLower}%"]);
                                    })
                                    ->orderBy('sort_order')
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(function (Widget $record) {
                                        $locale = app()->getLocale();
                                        $title = $record->getTranslation('title', $locale, false);
                                        if (!is_string($title) || $title === '') {
                                            $title = is_array($record->title) && !empty($record->title)
                                                ? (string)reset($record->title)
                                                : 'Widget #' . $record->id;
                                        }
                                        return [$record->id => $title];
                                    })
                                    ->toArray();
                            })
                            ->columnSpanFull()
                            ->reactive()
                    ]),

                Grid::make()
                    ->schema([
                        Section::make(__('General Information'))
                            ->columns()
                            ->collapsible()
                            ->description(__('Define the general information for the menu item.'))
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('Title'))
                                    ->required()
                                    ->validationMessages([
                                        'required' => __('admin.validation.required'),
                                    ]),
                                TextInput::make('url')
                                    ->label(__('URL'))
                                    ->required()
                                    ->validationMessages([
                                        'required' => __('admin.validation.required'),
                                    ]),
                                Select::make('target')
                                    ->label(__('Link Target'))
                                    ->options(UrlTarget::labels()),
                                TextInput::make('icon_class')
                                    ->label(__('Icon Class')),
                            ]),
                        Section::make(__('Media'))
                            ->columns(1)
                            ->collapsible()
                            ->description(__('Define the media information for the menu item.'))
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('icon')
                                    ->image()
                                    ->label(__('Icon'))
                                    ->disk('public')
                                    ->collection('icon')
                                    ->imagePreviewHeight('250')
                                    ->helperText(__('Recommended size: 1200x600px, Max size: 1MB')),
                            ]),
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

<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Language;
use Illuminate\Support\Str;
use App\Enums\MenuPosition;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Tabs\Tab;
use App\Enums\RichEditorFullToolBarButton;
use Filament\Forms\Components\DateTimePicker;
use App\Forms\Components\GoogleSearchPreview;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ProductForm
{
    public static function generateSKU($prefix = 'PRD'): string
    {
        $date = now()->format('ymd');
        $micro = substr(str_replace('.', '', microtime(true)), -6);
        $random = strtoupper(Str::random(4));
        return "{$prefix}-{$date}-{$micro}-{$random}";
    }

    public static function getDefaultTranslatableLocale(): string
    {
        return cache()->remember('default_translatable_locale', 3600, function () {
            return Language::query()->where('is_default', true)->value('code') ?? app()->getLocale();
        });
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([

                Tabs::make('productTabs')
                    ->persistTabInQueryString('tab')
                    ->tabs([
                        Tab::make(__('General'))
                            ->columns(2)
                            ->schema([
                                Section::make(__('Category Information'))
                                    ->collapsible()
                                    ->description(__('Define the category information for the product.'))
                                    ->schema([
                                        Select::make('brand_id')
                                            ->label(__('Brand'))
                                            ->required()
                                            ->relationship('brand', 'name')
                                            ->validationMessages([
                                                'required' => __('admin.validation.required'),
                                            ]),
                                        Select::make('categories')
                                            ->label(__('Categories'))
                                            ->required()
                                            ->multiple()
                                            ->relationship('categories', 'name', fn($query) => $query->orderBy('name'))
                                            ->preload()
                                            ->searchable()
                                            ->columnSpanFull()
                                            ->validationMessages([
                                                'required' => __('admin.validation.required'),
                                            ]),

                                        Select::make('tags')
                                            ->label(__('Tags'))
                                            ->multiple()
                                            ->relationship('tags', 'name', fn($query) => $query->orderBy('name'))
                                            ->preload()
                                            ->searchable()
                                            ->columnSpanFull(),
                                    ]),
                                Section::make(__('Price Information'))
                                    ->collapsible()
                                    ->description(__('Define the price information for the product.'))
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('price')
                                            ->label(__('Price'))
                                            ->required()
                                            ->numeric()
                                            ->prefix('$')
                                            ->validationMessages([
                                                'required' => __('admin.validation.required'),
                                                'numeric' => __('admin.validation.numeric'),
                                            ]),
                                        TextInput::make('compare_at_price')
                                            ->label(__('Compare Price'))
                                            ->numeric()
                                            ->prefix('$')
                                            ->nullable()
                                            ->default(null)
                                            ->helperText(__('Köhnə qiymət (opsional). API import üçün istifadə olunur.'))
                                            ->validationMessages([
                                                'numeric' => __('admin.validation.numeric'),
                                            ]),
                                        Select::make('currency')
                                            ->label(__('Currency'))
                                            ->options([
                                                'AZN' => 'AZN',
                                                'USD' => 'USD',
                                                'EUR' => 'EUR',
                                            ])
                                            ->columnSpanFull()
                                            ->default('AZN')
                                            ->required()
                                            ->validationMessages([
                                                'required' => __('admin.validation.required'),
                                            ]),
                                        Toggle::make('is_track_stock')
                                            ->label('Track Stock')
                                            ->live()
                                            ->helperText(__('Product appearance depends on stock.')),
                                        TextInput::make('stock_qty')
                                            ->label(__('Stock Quantity'))
                                            ->required(function (Get $get) {
                                                return $get('is_track_stock') == true;
                                            })
                                            ->numeric()
                                            ->disabled(function (Get $get) {
                                                return $get('is_track_stock') == false;
                                            })
                                            ->default(0)
                                            ->validationMessages([
                                                'required' => __('admin.validation.required'),
                                                'numeric' => __('admin.validation.numeric'),
                                            ]),
                                    ]),
                                Section::make(__('General Information'))
                                    ->collapsible()
                                    ->columnSpanFull()
                                    ->description(__('Define the general information for the product.'))
                                    ->schema([
                                        TextInput::make('sku')
                                            ->label('SKU')
                                            ->default(self::generateSKU())
                                            ->readOnly()
                                            ->required()
                                            ->validationMessages([
                                                'required' => __('admin.validation.required'),
                                            ]),
                                        TextInput::make('name')
                                            ->label(__('Name'))
                                            ->live(onBlur: true)
                                            ->columnSpanFull()
                                            ->required()
                                            ->afterStateUpdated(function ($state, Set $set, $livewire) {
                                                if ($livewire->activeLocale === self::getDefaultTranslatableLocale()) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            })
                                            ->validationMessages([
                                                'required' => __('admin.validation.required'),
                                            ]),
                                        RichEditor::make('short_description')
                                            ->label(__('Short Description'))
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'strike',
                                                'link',
                                                'bulletList',
                                                'orderedList',
                                            ])
                                            ->columnSpanFull(),
                                        RichEditor::make('description')
                                            ->label(__('Content'))
                                            ->toolbarButtons(RichEditorFullToolBarButton::getAll())
                                            ->columnSpanFull()
                                    ]),
                            ]),
                        Tab::make(__('Images'))
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('thumbnail')
                                    ->label(__('Thumbnail'))
                                    ->collection('thumbnail')
                                    ->image(),
                                SpatieMediaLibraryFileUpload::make('images')
                                    ->label(__('Gallery Images'))
                                    ->collection('images')
                                    ->multiple()
                                    ->reorderable()
                                    ->image(),
                            ]),
                        Tab::make(__('Seo'))
                            ->schema([
                                TextInput::make('slug')
                                    ->label(__('Slug'))
                                    ->live()
                                    ->columnSpanFull()
                                    ->required()
                                    ->dehydrated()
                                    ->readonly()
                                    ->validationMessages([
                                        'required' => __('admin.validation.required'),
                                    ]),
                                TextInput::make('meta_title')
                                    ->live()
                                    ->label(__('Meta Title')),
                                Textarea::make('meta_description')
                                    ->live()
                                    ->label(__('Meta Description')),
                                GoogleSearchPreview::make()
                                    ->baseUrl(config('app.site_url'))
                                    ->siteName(config('app.name'))
                                    ->faviconUrl(asset('favicon.png'))
                            ]),
                        Tab::make(__('Settings'))
                            ->columns(3)
                            ->schema([

                                TextInput::make('sort_order')
                                    ->hidden()
                                    ->required()
                                    ->numeric()
                                    ->default(Language::query()->max('sort_order') + 1)
                                    ->validationMessages([
                                        'required' => __('admin.validation.required'),
                                        'numeric' => __('admin.validation.numeric'),
                                    ]),

                                Select::make('is_new')
                                    ->label(__('New Product'))
                                    ->options([
                                        true => __('New'),
                                        false => __('Normal'),
                                    ]),

                                Select::make('is_hot')
                                    ->label(__('Hot Product'))
                                    ->options([
                                        true => __('Hot'),
                                        false => __('Normal'),
                                    ]),

                                Select::make('is_featured')
                                    ->label(__('Featured'))
                                    ->live()
                                    ->options([
                                        true => __('Featured'),
                                        false => __('Normal'),
                                    ]),

                                Select::make('featured_menus')
                                    ->label(__('Featured Menus'))
                                    ->multiple()
                                    ->hidden(function (Get $get) {
                                        return $get('is_featured') == '0';
                                    })
                                    ->relationship(
                                        name: 'menus',
                                        titleAttribute: 'title',
                                        modifyQueryUsing: function ($query) {
                                            $query->where('position', MenuPosition::FEATURED->value)->orderBy('title');
                                        }
                                    )
                                    ->required(function (Get $get) {
                                        return $get('is_featured') == true;
                                    })
                                    ->preload()
                                    ->searchable()
                                    ->columnSpanFull()
                                    ->validationMessages([
                                        'required' => __('admin.validation.required'),
                                    ]),

                                Select::make('discounts')
                                    ->label(__('Discounts'))
                                    ->multiple()
                                    ->relationship(
                                        name: 'discounts',
                                        titleAttribute: 'name'
                                    )
                                    ->preload()
                                    ->searchable()
                                    ->columnSpanFull(),


                                Toggle::make('is_active')
                                    ->label(__('Active'))
                                    ->columnSpanFull(),
                            ]),
                        Tab::make(__('Attributes'))
                            ->schema([
                                Tabs::make('productAttributesTabs')
                                    ->persistTabInQueryString('attributes_tab')
                                    ->tabs([
                                        Tab::make(__('Attributes'))
                                            ->schema([
                                                KeyValue::make('attributes')
                                                    ->label(__('Attributes'))
                                                    ->keyLabel(__('Attribute Name'))
                                                    ->valueLabel(__('Attribute Value'))
                                                    ->deleteAction(fn(Action $action) => $action->icon('heroicon-m-trash')),
                                            ]),
                                        Tab::make(__('Specifications'))
                                            ->schema([
                                                KeyValue::make('specs')
                                                    ->label(__('Specifications'))
                                                    ->keyLabel(__('Specification Name'))
                                                    ->valueLabel(__('Specification Value'))
                                                    ->deleteAction(fn(Action $action) => $action->icon('heroicon-m-trash'))
                                            ]),
                                    ]),
                            ])
                    ]),
            ]);
    }
}

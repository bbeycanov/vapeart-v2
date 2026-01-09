<?php

namespace App\Filament\Resources\Reviews\Schemas;

use App\Models\Blog;
use App\Models\Product;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('Review Information'))
                    ->columns(2)
                    ->collapsible()
                    ->description(__('Define the review information.'))
                    ->schema([
                        Select::make('reviewable_type')
                            ->label(__('Review Type'))
                            ->options([
                                Blog::class => __('Blog'),
                                Product::class => __('Product'),
                            ])
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('reviewable_id', null))
                            ->validationMessages([
                                'required' => __('admin.validation.required'),
                            ]),
                        Select::make('reviewable_id')
                            ->label(__('Item'))
                            ->required()
                            ->searchable()
                            ->validationMessages([
                                'required' => __('admin.validation.required'),
                            ])
                            ->getSearchResultsUsing(function (string $search, callable $get) {
                                $type = $get('reviewable_type');
                                if (!$type) {
                                    return [];
                                }
                                
                                return match ($type) {
                                    Blog::class => Blog::query()
                                        ->where(function ($query) use ($search) {
                                            $query->where('slug', 'like', "%{$search}%");
                                            foreach (['en', 'az', 'ru'] as $locale) {
                                                $query->orWhereRaw("JSON_EXTRACT(title, '$.{$locale}') LIKE ?", ["%{$search}%"]);
                                            }
                                        })
                                        ->limit(50)
                                        ->get()
                                        ->mapWithKeys(fn ($item) => [
                                            $item->id => $item->getTranslation('title', app()->getLocale()) ?? $item->slug ?? "Blog #{$item->id}"
                                        ]),
                                    Product::class => Product::query()
                                        ->where(function ($query) use ($search) {
                                            $query->where('slug', 'like', "%{$search}%");
                                            foreach (['en', 'az', 'ru'] as $locale) {
                                                $query->orWhereRaw("JSON_EXTRACT(name, '$.{$locale}') LIKE ?", ["%{$search}%"]);
                                            }
                                        })
                                        ->limit(50)
                                        ->get()
                                        ->mapWithKeys(fn ($item) => [
                                            $item->id => $item->getTranslation('name', app()->getLocale()) ?? $item->slug ?? "Product #{$item->id}"
                                        ]),
                                    default => [],
                                };
                            })
                            ->getOptionLabelUsing(function ($value, callable $get) {
                                if (!$value) {
                                    return null;
                                }
                                
                                $type = $get('reviewable_type');
                                if (!$type) {
                                    return null;
                                }
                                
                                return match ($type) {
                                    Blog::class => Blog::find($value)?->getTranslation('title', app()->getLocale()) ?? Blog::find($value)?->slug ?? "Blog #{$value}",
                                    Product::class => Product::find($value)?->getTranslation('name', app()->getLocale()) ?? Product::find($value)?->slug ?? "Product #{$value}",
                                    default => null,
                                };
                            })
                            ->visible(fn (callable $get) => !empty($get('reviewable_type')))
                            ->disabled(fn ($context) => $context === 'edit'),
                        TextInput::make('author_name')
                            ->label(__('Author Name'))
                            ->required()
                            ->maxLength(120)
                            ->validationMessages([
                                'required' => __('admin.validation.required'),
                                'max' => __('admin.validation.max_length', ['max' => 120]),
                            ]),
                        TextInput::make('author_email')
                            ->label(__('Author Email'))
                            ->email()
                            ->required()
                            ->maxLength(150)
                            ->validationMessages([
                                'required' => __('admin.validation.required'),
                                'email' => __('admin.validation.email'),
                                'max' => __('admin.validation.max_length', ['max' => 150]),
                            ]),
                        TextInput::make('rating')
                            ->label(__('Rating'))
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(5)
                            ->default(5)
                            ->validationMessages([
                                'required' => __('admin.validation.required'),
                                'numeric' => __('admin.validation.numeric'),
                                'min' => __('admin.validation.min_value', ['min' => 1]),
                                'max' => __('admin.validation.max_value', ['max' => 5]),
                            ]),
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->maxLength(150)
                            ->columnSpanFull()
                            ->validationMessages([
                                'max' => __('admin.validation.max_length', ['max' => 150]),
                            ]),
                        Textarea::make('body')
                            ->label(__('Body'))
                            ->rows(4)
                            ->maxLength(5000)
                            ->columnSpanFull()
                            ->validationMessages([
                                'max' => __('admin.validation.max_length', ['max' => 5000]),
                            ]),
                    ]),
                Section::make(__('Status'))
                    ->collapsible()
                    ->description(__('Define the status information for the review.'))
                    ->schema([
                        Toggle::make('status')
                            ->label(__('Approved'))
                            ->default(1)
                            ->helperText(__('Toggle to approve or reject this review')),
                        DateTimePicker::make('published_at')
                            ->label(__('Published at'))
                            ->default(now())
                            ->displayFormat('d/m/Y H:i')
                            ->timezone('UTC'),
                    ]),
            ]);
    }
}


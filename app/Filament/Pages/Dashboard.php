<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DiscountsStatsWidget;
use App\Filament\Widgets\ProductPriceRangeChart;
use App\Filament\Widgets\ProductsChart;
use App\Filament\Widgets\ProductsStatsWidget;
use App\Filament\Widgets\ReviewRatingsChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TopBrandsChart;
use App\Filament\Widgets\TopCategoriesChart;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function getTitle(): string
    {
        return __('Dashboard');
    }

    public static function getNavigationLabel(): string
    {
        return __('Dashboard');
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->label(__('Start Date'))
                            ->default(now()->subDays(30))
                            ->live(),
                        DatePicker::make('endDate')
                            ->label(__('End Date'))
                            ->default(now())
                            ->live(),
                    ])
                    ->columns(2),
            ]);
    }

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            ProductsStatsWidget::class,
            DiscountsStatsWidget::class,
            TopCategoriesChart::class,
            TopBrandsChart::class,
            ProductsChart::class,
            ReviewRatingsChart::class,
            ProductPriceRangeChart::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 2;
    }
}


<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProductsChart extends ApexChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $chartId = 'productsChart';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    protected function getHeading(): string
    {
        return __('Products Overview');
    }

    protected function getOptions(): array
    {
        $startDate = $this->filters['startDate'] ?? now()->subDays(30);
        $endDate = $this->filters['endDate'] ?? now();

        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        $productsTrend = Trend::model(Product::class)
            ->between(start: $startDate, end: $endDate)
            ->perDay()
            ->count();

        $activeProductsTrend = Trend::query(Product::where('is_active', true))
            ->between(start: $startDate, end: $endDate)
            ->perDay()
            ->count();

        return [
            'chart' => [
                'type' => 'area',
                'height' => 300,
                'toolbar' => [
                    'show' => true,
                ],
            ],
            'series' => [
                [
                    'name' => __('All Products'),
                    'data' => $productsTrend->map(fn(TrendValue $value) => $value->aggregate)->toArray(),
                ],
                [
                    'name' => __('Active Products'),
                    'data' => $activeProductsTrend->map(fn(TrendValue $value) => $value->aggregate)->toArray(),
                ],
            ],
            'xaxis' => [
                'categories' => $productsTrend->map(fn(TrendValue $value) => Carbon::parse($value->date)->format('M d'))->toArray(),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#6366f1', '#10b981'],
            'stroke' => [
                'curve' => 'smooth',
                'width' => 2,
            ],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shadeIntensity' => 1,
                    'opacityFrom' => 0.45,
                    'opacityTo' => 0.05,
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'legend' => [
                'position' => 'top',
            ],
        ];
    }
}


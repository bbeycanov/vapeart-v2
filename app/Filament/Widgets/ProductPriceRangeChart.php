<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\Cache;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ProductPriceRangeChart extends ApexChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $chartId = 'productPriceRangeChart';
    protected static ?int $sort = 8;
    protected int|string|array $columnSpan = 1;

    protected function getHeading(): string
    {
        return __('Price Distribution');
    }

    protected function getOptions(): array
    {
        $data = Cache::remember('dashboard_price_distribution', 3600, function () {
            return [
                '0-50' => Product::where('is_active', true)->whereBetween('price', [0, 50])->count(),
                '50-100' => Product::where('is_active', true)->whereBetween('price', [50, 100])->count(),
                '100-200' => Product::where('is_active', true)->whereBetween('price', [100, 200])->count(),
                '200-500' => Product::where('is_active', true)->whereBetween('price', [200, 500])->count(),
                '500+' => Product::where('is_active', true)->where('price', '>', 500)->count(),
            ];
        });

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 250,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => [
                [
                    'name' => __('Products'),
                    'data' => array_values($data),
                ],
            ],
            'xaxis' => [
                'categories' => ['0-50 ₼', '50-100 ₼', '100-200 ₼', '200-500 ₼', '500+ ₼'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#06b6d4'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 4,
                    'columnWidth' => '60%',
                    'distributed' => true,
                ],
            ],
            'dataLabels' => [
                'enabled' => true,
            ],
            'legend' => [
                'show' => false,
            ],
        ];
    }
}

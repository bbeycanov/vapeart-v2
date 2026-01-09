<?php

namespace App\Filament\Widgets;

use App\Models\Brand;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class TopBrandsChart extends ApexChartWidget
{
    protected static ?string $chartId = 'topBrandsChart';
    protected static ?int $sort = 10;
    protected int|string|array $columnSpan = 1;

    protected function getHeading(): string
    {
        return __('Top Brands');
    }

    protected function getOptions(): array
    {
        // Show all active products per brand (not filtered by date)
        $brands = Brand::withCount(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->where('is_active', true)
            ->having('products_count', '>', 0)
            ->orderByDesc('products_count')
            ->limit(5)
            ->get();

        $locale = app()->getLocale();

        return [
            'chart' => [
                'type' => 'polarArea',
                'height' => 250,
            ],
            'series' => $brands->pluck('products_count')->toArray(),
            'labels' => $brands->map(fn($brand) => $brand->getTranslation('name', $locale) ?? $brand->name)->toArray(),
            'colors' => ['#f43f5e', '#06b6d4', '#84cc16', '#a855f7', '#f97316'],
            'legend' => [
                'position' => 'bottom',
            ],
            'stroke' => [
                'colors' => ['#fff'],
            ],
            'fill' => [
                'opacity' => 0.8,
            ],
        ];
    }
}


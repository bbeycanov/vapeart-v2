<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class TopCategoriesChart extends ApexChartWidget
{
    protected static ?string $chartId = 'topCategoriesChart';
    protected static ?int $sort = 9;
    protected int|string|array $columnSpan = 1;

    protected function getHeading(): string
    {
        return __('Top Categories');
    }

    protected function getOptions(): array
    {
        // Show all active products per category (not filtered by date)
        $categories = Category::withCount(['products' => function ($query) {
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
                'type' => 'pie',
                'height' => 250,
            ],
            'series' => $categories->pluck('products_count')->toArray(),
            'labels' => $categories->map(fn($cat) => $cat->getTranslation('name', $locale) ?? $cat->name)->toArray(),
            'colors' => ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6'],
            'legend' => [
                'position' => 'bottom',
            ],
            'dataLabels' => [
                'enabled' => true,
            ],
        ];
    }
}


<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
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
        $locale = app()->getLocale();

        $data = Cache::remember('dashboard_top_categories_' . $locale, 3600, function () use ($locale) {
            $categories = Category::withCount(['products' => function ($query) {
                    $query->where('is_active', true);
                }])
                ->where('is_active', true)
                ->having('products_count', '>', 0)
                ->orderByDesc('products_count')
                ->limit(5)
                ->get();

            return [
                'series' => $categories->pluck('products_count')->toArray(),
                'labels' => $categories->map(fn($cat) => $cat->getTranslation('name', $locale) ?? $cat->name)->toArray(),
            ];
        });

        return [
            'chart' => [
                'type' => 'pie',
                'height' => 250,
            ],
            'series' => $data['series'],
            'labels' => $data['labels'],
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

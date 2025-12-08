<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class TopCategoriesChart extends ApexChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $chartId = 'topCategoriesChart';
    protected static ?int $sort = 9;
    protected int|string|array $columnSpan = 1;

    protected function getHeading(): string
    {
        return __('Top Categories');
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

        $categories = Category::withCount(['products' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->where('is_active', true)
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


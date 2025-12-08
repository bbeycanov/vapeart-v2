<?php

namespace App\Filament\Widgets;

use App\Models\Brand;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class TopBrandsChart extends ApexChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $chartId = 'topBrandsChart';
    protected static ?int $sort = 10;
    protected int|string|array $columnSpan = 1;

    protected function getHeading(): string
    {
        return __('Top Brands');
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

        $brands = Brand::withCount(['products' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->where('is_active', true)
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


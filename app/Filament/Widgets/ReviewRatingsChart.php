<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ReviewRatingsChart extends ApexChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $chartId = 'reviewRatingsChart';
    protected static ?int $sort = 6;
    protected int|string|array $columnSpan = 1;

    protected function getHeading(): string
    {
        return __('Rating Distribution');
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

        $ratings = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratings[$i] = Review::where('rating', $i)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
        }

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
                    'name' => __('Reviews'),
                    'data' => array_values($ratings),
                ],
            ],
            'xaxis' => [
                'categories' => ['⭐', '⭐⭐', '⭐⭐⭐', '⭐⭐⭐⭐', '⭐⭐⭐⭐⭐'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                        'fontSize' => '14px',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => true,
                    'borderRadius' => 4,
                    'barHeight' => '60%',
                ],
            ],
            'dataLabels' => [
                'enabled' => true,
            ],
        ];
    }
}


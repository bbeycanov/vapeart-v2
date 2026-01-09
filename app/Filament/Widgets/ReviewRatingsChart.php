<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\Cache;
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
        $data = Cache::remember('dashboard_review_ratings', 3600, function () {
            $ratings = [];
            for ($i = 1; $i <= 5; $i++) {
                $ratings[$i] = Review::where('rating', $i)
                    ->where('status', 1)
                    ->count();
            }
            return $ratings;
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
                    'name' => __('Reviews'),
                    'data' => array_values($data),
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

<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ProductsStatsWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 12;

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? now()->subDays(30);
        $endDate = $this->filters['endDate'] ?? now();

        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        $baseQuery = Product::where('is_active', true)->whereBetween('created_at', [$startDate, $endDate]);

        $featuredProducts = (clone $baseQuery)->where('is_featured', true)->count();
        $newProducts = (clone $baseQuery)->where('is_new', true)->count();
        $hotProducts = (clone $baseQuery)->where('is_hot', true)->count();
        $avgPrice = (clone $baseQuery)->avg('price');
        $totalStockValue = (clone $baseQuery)->selectRaw('SUM(price * stock_qty) as total')->value('total');

        return [
            Stat::make(__('Featured'), $featuredProducts)
                ->description(__('Featured products'))
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make(__('New'), $newProducts)
                ->description(__('New arrivals'))
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('info'),

            Stat::make(__('Hot'), $hotProducts)
                ->description(__('Hot products'))
                ->descriptionIcon('heroicon-m-fire')
                ->color('danger'),

            Stat::make(__('Avg. Price'), number_format($avgPrice ?? 0, 2) . ' ₼')
                ->description(__('Average product price'))
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}


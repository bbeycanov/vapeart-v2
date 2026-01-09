<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductsStatsWidget extends BaseWidget
{
    protected static ?int $sort = 12;

    protected function getStats(): array
    {
        // Show all active products (not filtered by date)
        $baseQuery = Product::where('is_active', true);

        $featuredProducts = (clone $baseQuery)->where('is_featured', true)->count();
        $newProducts = (clone $baseQuery)->where('is_new', true)->count();
        $hotProducts = (clone $baseQuery)->where('is_hot', true)->count();
        $avgPrice = (clone $baseQuery)->avg('price');
        $outOfStock = (clone $baseQuery)->where('stock_qty', '<=', 0)->count();

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
                ->description(__('Out of stock') . ': ' . $outOfStock)
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}


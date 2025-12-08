<?php

namespace App\Filament\Widgets;

use App\Models\Discount;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class DiscountsStatsWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 11;

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

        $now = now();

        $activeDiscounts = Discount::where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
            })
            ->count();

        $expiredDiscounts = Discount::whereNotNull('end_date')
            ->where('end_date', '<', $now)
            ->count();

        $upcomingDiscounts = Discount::whereNotNull('start_date')
            ->where('start_date', '>', $now)
            ->count();

        $totalUsage = Discount::sum('used_count');

        return [
            Stat::make(__('Active Discounts'), $activeDiscounts)
                ->description(__('Currently running'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make(__('Expired'), $expiredDiscounts)
                ->description(__('Ended discounts'))
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make(__('Upcoming'), $upcomingDiscounts)
                ->description(__('Starting soon'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make(__('Total Usage'), $totalUsage)
                ->description(__('Times used'))
                ->descriptionIcon('heroicon-m-receipt-percent')
                ->color('info'),
        ];
    }
}


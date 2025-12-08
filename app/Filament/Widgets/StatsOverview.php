<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

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

        // Products trend
        $productsTrend = Trend::model(Product::class)
            ->between(start: $startDate, end: $endDate)
            ->perDay()
            ->count();

        // Reviews trend
        $reviewsTrend = Trend::model(Review::class)
            ->between(start: $startDate, end: $endDate)
            ->perDay()
            ->count();

        // Contact messages trend
        $messagesTrend = Trend::model(ContactMessage::class)
            ->between(start: $startDate, end: $endDate)
            ->perDay()
            ->count();

        // Users trend
        $usersTrend = Trend::model(User::class)
            ->between(start: $startDate, end: $endDate)
            ->perDay()
            ->count();

        return [
            Stat::make(__('Total Products'), Product::count())
                ->description(__('Active') . ': ' . Product::where('is_active', true)->count())
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->chart($productsTrend->map(fn(TrendValue $value) => $value->aggregate)->toArray())
                ->color('success'),

            Stat::make(__('Categories'), Category::count())
                ->description(__('With products') . ': ' . Category::whereHas('products')->count())
                ->descriptionIcon('heroicon-m-folder')
                ->color('info'),

            Stat::make(__('Brands'), Brand::count())
                ->description(__('Active') . ': ' . Brand::where('is_active', true)->count())
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('warning'),

            Stat::make(__('Users'), User::count())
                ->description(__('New this period') . ': ' . User::whereBetween('created_at', [$startDate, $endDate])->count())
                ->descriptionIcon('heroicon-m-users')
                ->chart($usersTrend->map(fn(TrendValue $value) => $value->aggregate)->toArray())
                ->color('primary'),

            Stat::make(__('Reviews'), Review::count())
                ->description(__('Pending') . ': ' . Review::where('status', 0)->count())
                ->descriptionIcon('heroicon-m-star')
                ->chart($reviewsTrend->map(fn(TrendValue $value) => $value->aggregate)->toArray())
                ->color('success'),

            Stat::make(__('Unread Messages'), ContactMessage::where('is_read', false)->count())
                ->description(__('Total') . ': ' . ContactMessage::count())
                ->descriptionIcon('heroicon-m-envelope')
                ->chart($messagesTrend->map(fn(TrendValue $value) => $value->aggregate)->toArray())
                ->color('danger'),
        ];
    }
}


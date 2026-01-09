<?php

namespace App\Filament\Widgets;

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
use Illuminate\Support\Facades\Cache;

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

        $cacheKey = 'dashboard_stats_overview_' . $startDate->format('Y-m-d') . '_' . $endDate->format('Y-m-d');

        $data = Cache::remember($cacheKey, 3600, function () use ($startDate, $endDate) {
            $productsTrend = Trend::model(Product::class)
                ->between(start: $startDate, end: $endDate)
                ->perDay()
                ->count();

            $reviewsTrend = Trend::model(Review::class)
                ->between(start: $startDate, end: $endDate)
                ->perDay()
                ->count();

            $messagesTrend = Trend::model(ContactMessage::class)
                ->between(start: $startDate, end: $endDate)
                ->perDay()
                ->count();

            $usersTrend = Trend::model(User::class)
                ->between(start: $startDate, end: $endDate)
                ->perDay()
                ->count();

            return [
                'totalProducts' => Product::count(),
                'activeProducts' => Product::where('is_active', true)->count(),
                'productsTrend' => $productsTrend->map(fn(TrendValue $value) => $value->aggregate)->toArray(),
                'totalCategories' => Category::count(),
                'categoriesWithProducts' => Category::whereHas('products')->count(),
                'totalBrands' => Brand::count(),
                'activeBrands' => Brand::where('is_active', true)->count(),
                'totalUsers' => User::count(),
                'newUsers' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
                'usersTrend' => $usersTrend->map(fn(TrendValue $value) => $value->aggregate)->toArray(),
                'totalReviews' => Review::count(),
                'pendingReviews' => Review::where('status', 0)->count(),
                'reviewsTrend' => $reviewsTrend->map(fn(TrendValue $value) => $value->aggregate)->toArray(),
                'unreadMessages' => ContactMessage::where('is_read', false)->count(),
                'totalMessages' => ContactMessage::count(),
                'messagesTrend' => $messagesTrend->map(fn(TrendValue $value) => $value->aggregate)->toArray(),
            ];
        });

        return [
            Stat::make(__('Total Products'), $data['totalProducts'])
                ->description(__('Active') . ': ' . $data['activeProducts'])
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->chart($data['productsTrend'])
                ->color('success'),

            Stat::make(__('Categories'), $data['totalCategories'])
                ->description(__('With products') . ': ' . $data['categoriesWithProducts'])
                ->descriptionIcon('heroicon-m-folder')
                ->color('info'),

            Stat::make(__('Brands'), $data['totalBrands'])
                ->description(__('Active') . ': ' . $data['activeBrands'])
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('warning'),

            Stat::make(__('Users'), $data['totalUsers'])
                ->description(__('New this period') . ': ' . $data['newUsers'])
                ->descriptionIcon('heroicon-m-users')
                ->chart($data['usersTrend'])
                ->color('primary'),

            Stat::make(__('Reviews'), $data['totalReviews'])
                ->description(__('Pending') . ': ' . $data['pendingReviews'])
                ->descriptionIcon('heroicon-m-star')
                ->chart($data['reviewsTrend'])
                ->color('success'),

            Stat::make(__('Unread Messages'), $data['unreadMessages'])
                ->description(__('Total') . ': ' . $data['totalMessages'])
                ->descriptionIcon('heroicon-m-envelope')
                ->chart($data['messagesTrend'])
                ->color('danger'),
        ];
    }
}

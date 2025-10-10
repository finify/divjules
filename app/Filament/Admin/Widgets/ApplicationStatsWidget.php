<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Application;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ApplicationStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Get application statistics
        $totalApplications = Application::count();
        $thisMonthApplications = Application::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $lastMonthApplications = Application::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $pendingApplications = Application::where('status', 'pending')->count();
        $submittedApplications = Application::where('status', 'submitted')->count();
        $processingApplications = Application::where('status', 'processing')->count();
        $completedApplications = Application::where('status', 'completed')->count();

        // Calculate growth percentage
        $growthPercentage = $lastMonthApplications > 0
            ? round((($thisMonthApplications - $lastMonthApplications) / $lastMonthApplications) * 100, 1)
            : 100;

        return [
            Stat::make('Total Applications', $totalApplications)
                ->description($thisMonthApplications . ' this month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($this->getApplicationTrendData()),

            Stat::make('Pending Review', $pendingApplications + $submittedApplications)
                ->description($submittedApplications . ' submitted, ' . $pendingApplications . ' pending')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('In Processing', $processingApplications)
                ->description($completedApplications . ' completed')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),

            Stat::make('Monthly Growth', ($growthPercentage >= 0 ? '+' : '') . $growthPercentage . '%')
                ->description('Compared to last month')
                ->descriptionIcon($growthPercentage >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($growthPercentage >= 0 ? 'success' : 'danger'),
        ];
    }

    protected function getApplicationTrendData(): array
    {
        // Get last 7 days of application counts
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = Application::whereDate('created_at', $date)->count();
            $data[] = $count;
        }
        return $data;
    }
}

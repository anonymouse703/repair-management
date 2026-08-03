<?php

namespace App\Filament\Widgets;

use App\Models\JobOrder;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalRevenue = Payment::sum('amount');

        $revenueToday = Payment::whereDate('paid_at', today())
            ->sum('amount');

        $outstandingBalance = JobOrder::query()
            ->sum(\DB::raw('estimate_total - paid_total'));

        $averagePayment = Payment::avg('amount');

        return [
            Stat::make(
                'Total Revenue',
                '₱' . number_format($totalRevenue, 2)
            )
                ->description('All recorded payments')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make(
                'Revenue Today',
                '₱' . number_format($revenueToday, 2)
            )
                ->description('Collected today')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make(
                'Outstanding Balance',
                '₱' . number_format($outstandingBalance, 2)
            )
                ->description('Remaining customer balances')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('warning'),

            Stat::make(
                'Average Payment',
                '₱' . number_format($averagePayment, 2)
            )
                ->description('Per payment transaction')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('gray'),
        ];
    }
}
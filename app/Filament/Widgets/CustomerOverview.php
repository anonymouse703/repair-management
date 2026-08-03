<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\JobOrder;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 4;

    protected function getStats(): array
    {
        $totalCustomers = Customer::count();

        $newCustomersToday = Customer::whereDate(
            'created_at',
            today()
        )->count();

        $returningCustomers = Customer::has('jobOrders', '>', 1)
            ->count();

        $customersWithBalance = Customer::whereHas('jobOrders', function ($query) {
            $query->whereColumn('paid_total', '<', 'estimate_total');
        })->count();

        return [
            Stat::make(
                'Total Customers',
                number_format($totalCustomers)
            )
                ->description('Registered customers')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make(
                'New Customers Today',
                number_format($newCustomersToday)
            )
                ->description('Registered today')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success'),

            Stat::make(
                'Returning Customers',
                number_format($returningCustomers)
            )
                ->description('More than one job order')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),

            Stat::make(
                'Customers with Balance',
                number_format($customersWithBalance)
            )
                ->description('Outstanding payments')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('warning'),
        ];
    }
}
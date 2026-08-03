<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ActiveRepairsTable;
use App\Filament\Widgets\CustomerOverview;
use App\Filament\Widgets\DeviceBrandChart;
use App\Filament\Widgets\DeviceOverview;
use App\Filament\Widgets\JobOrderOverview;
use App\Filament\Widgets\JobOrderTrendChart;
use App\Filament\Widgets\JobStatusChart;
use App\Filament\Widgets\OutstandingBalancesTable;
use App\Filament\Widgets\OverdueJobOrdersTable;
use App\Filament\Widgets\PaymentMethodChart;
use App\Filament\Widgets\ReadyForPickupTable;
use App\Filament\Widgets\RecentJobOrders;
use App\Filament\Widgets\RecentPayments;
use App\Filament\Widgets\RevenueChart;
use App\Filament\Widgets\RevenueOverview;
use App\Filament\Widgets\ServicePopularityChart;
use App\Filament\Widgets\TechnicianOverview;
use App\Filament\Widgets\WaitingForPartsTable;
use App\Filament\Widgets\WorkshopOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int | array
    {
        return 2;
    }

    public function getWidgets(): array
    {
        return [
            JobOrderOverview::class,
            RevenueOverview::class,
            WorkshopOverview::class,
            CustomerOverview::class,
            DeviceOverview::class,
            TechnicianOverview::class,
            RevenueChart::class,
            JobOrderTrendChart::class,
            JobStatusChart::class,
            PaymentMethodChart::class,
            DeviceBrandChart::class,
            ServicePopularityChart::class,
            RecentJobOrders::class,
            RecentPayments::class,
            ReadyForPickupTable::class,
            OutstandingBalancesTable::class,
            ActiveRepairsTable::class,
            WaitingForPartsTable::class,
            OverdueJobOrdersTable::class,
        ];
    }
    
}
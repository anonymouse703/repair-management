<?php

namespace App\Filament\Widgets;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class JobOrderOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Job Orders',
                JobOrder::count()
            )
                ->description('All job orders')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),

            Stat::make(
                'Received Today',
                JobOrder::whereDate('received_at', today())->count()
            )
                ->description('Received today')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('info'),

            Stat::make(
                'Ready for Pickup',
                JobOrder::where('status', Status::ReadyForPickup)->count()
            )
                ->description('Waiting for customer')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make(
                'Released Today',
                JobOrder::where('status', Status::Released)
                    ->whereDate('released_at', today())
                    ->count()
            )
                ->description('Released today')
                ->descriptionIcon('heroicon-m-arrow-up-tray')
                ->color('gray'),
        ];
    }
}
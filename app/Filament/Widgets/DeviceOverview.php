<?php

namespace App\Filament\Widgets;

use App\Enums\JobOrder\Status;
use App\Models\Device;
use App\Models\JobOrder;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DeviceOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 5;

    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Devices',
                number_format(Device::count())
            )
                ->description('Registered devices')
                ->descriptionIcon('heroicon-m-device-phone-mobile')
                ->color('primary'),

            Stat::make(
                'Under Repair',
                JobOrder::where('status', Status::Repairing)->count()
            )
                ->description('Currently being repaired')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('warning'),

            Stat::make(
                'Waiting for Parts',
                JobOrder::where('status', Status::WaitingParts)->count()
            )
                ->description('Awaiting replacement parts')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),

            Stat::make(
                'Ready for Pickup',
                JobOrder::where('status', Status::ReadyForPickup)->count()
            )
                ->description('Waiting for customer')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
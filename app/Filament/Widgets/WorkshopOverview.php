<?php

namespace App\Filament\Widgets;

use App\Enums\JobOrder\Status;
use App\Enums\User\Role;
use App\Models\JobOrder;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WorkshopOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        return [

            Stat::make(
                'Active Repairs',
                JobOrder::where('status', Status::Repairing)->count()
            )
                ->description('Currently under repair')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('primary'),

            Stat::make(
                'Waiting for Parts',
                JobOrder::where('status', Status::WaitingParts)->count()
            )
                ->description('Awaiting inventory')
                ->descriptionIcon('heroicon-m-cube')
                ->color('warning'),

            Stat::make(
                'Under Diagnosis',
                JobOrder::where('status', Status::Diagnosing)->count()
            )
                ->description('Being inspected')
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color('info'),

            Stat::make(
                'Technicians',
                User::where('role', Role::Technician)->count()
            )
                ->description('Registered technicians')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

        ];
    }
}
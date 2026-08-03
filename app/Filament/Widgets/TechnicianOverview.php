<?php

namespace App\Filament\Widgets;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use App\Models\Technician;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TechnicianOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 6;

    protected function getStats(): array
    {
        $busyStatuses = [
            Status::Diagnosing,
            Status::WaitingApproval,
            Status::WaitingParts,
            Status::Repairing,
            Status::Testing,
        ];

        $busyTechnicians = Technician::whereHas('jobOrders', function ($query) use ($busyStatuses) {
            $query->whereIn('status', $busyStatuses);
        })->count();

        $totalTechnicians = Technician::count();

        return [
            Stat::make(
                'Total Technicians',
                number_format($totalTechnicians)
            )
                ->description('Registered technicians')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make(
                'Busy Technicians',
                number_format($busyTechnicians)
            )
                ->description('Currently assigned')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('warning'),

            Stat::make(
                'Available Technicians',
                number_format($totalTechnicians - $busyTechnicians)
            )
                ->description('No active jobs')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make(
                'Jobs Assigned',
                number_format(
                    JobOrder::whereIn('status', $busyStatuses)->count()
                )
            )
                ->description('Active repair jobs')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info'),
        ];
    }
}
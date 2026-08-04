<?php

namespace App\Filament\Widgets;

use App\Models\InventoryItem;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InventoryOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 4;

    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Items',
                InventoryItem::count()
            )
                ->description('All inventory records')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),

            Stat::make(
                'Active Items',
                InventoryItem::where('active', true)->count()
            )
                ->description('Available inventory')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make(
                'Low Stock',
                InventoryItem::query()
                    ->whereColumn('quantity', '<=', 'reorder_level')
                    ->where('quantity', '>', 0)
                    ->where('active', true)
                    ->count()
            )
                ->description('Needs restocking soon')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),

            Stat::make(
                'Out of Stock',
                InventoryItem::query()
                    ->where('quantity', 0)
                    ->where('active', true)
                    ->count()
            )
                ->description('No stock available')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\JobOrder;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class JobOrderTrendChart extends ChartWidget
{
    protected ?string $heading = 'Job Order Trend (This Month)';

    protected function getData(): array
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $jobOrders = JobOrder::query()
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $labels = [];
        $data = [];

        foreach (CarbonPeriod::create($start, $end) as $date) {
            $key = $date->toDateString();

            $labels[] = $date->format('M d');
            $data[] = (int) ($jobOrders[$key] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Job Orders',
                    'data' => $data,
                ],
            ],

            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
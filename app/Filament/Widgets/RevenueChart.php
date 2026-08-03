<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected ?string $heading = 'Revenue (This Month)';

    protected static ?int $sort = 10;

    protected function getData(): array
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $payments = Payment::query()
            ->whereBetween('paid_at', [$start, $end])
            ->selectRaw('DATE(paid_at) as date')
            ->selectRaw('SUM(amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $labels = [];
        $data = [];

        foreach (CarbonPeriod::create($start, $end) as $date) {
            $key = $date->toDateString();

            $labels[] = $date->format('M d');
            $data[] = (float) ($payments[$key] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $data,
                    'fill' => false,
                    'tension' => 0.3,
                ],
            ],

            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
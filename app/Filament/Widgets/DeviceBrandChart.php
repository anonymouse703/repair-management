<?php

namespace App\Filament\Widgets;

use App\Models\Brand;
use App\Models\Device;
use App\Models\JobOrder;
use Filament\Widgets\ChartWidget;

class DeviceBrandChart extends ChartWidget
{
    protected ?string $heading = 'Device Brand Chart';

    protected function getData(): array
    {
        $brandCounts = JobOrder::query()
            ->join('devices', 'job_orders.device_id', '=', 'devices.id')
            ->join('brands', 'devices.brand_id', '=', 'brands.id')
            ->selectRaw('brands.name as brand_name, COUNT(job_orders.id) as total')
            ->groupBy('brands.name')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('total', 'brand_name');

        return [
            'datasets' => [
                [
                    'label' => 'Job Orders',
                    'data' => $brandCounts->values()->all(),
                    'backgroundColor' => 'rgb(99, 102, 241)',
                ],
            ],

            'labels' => $brandCounts->keys()->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y', // horizontal bar
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
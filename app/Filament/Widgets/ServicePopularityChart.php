<?php

namespace App\Filament\Widgets;

use App\Models\Service;
use Filament\Widgets\ChartWidget;

class ServicePopularityChart extends ChartWidget
{
    protected ?string $heading = 'Service Popularity Chart';

    protected function getData(): array
    {
        $serviceCounts = Service::query()
            ->join('job_order_service', 'services.id', '=', 'job_order_service.service_id')
            ->selectRaw('services.name as service_name, SUM(job_order_service.quantity) as total')
            ->groupBy('services.name')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('total', 'service_name');

        return [
            'datasets' => [
                [
                    'label' => 'Times Requested',
                    'data' => $serviceCounts->values()->all(),
                    'backgroundColor' => 'rgb(34, 197, 94)',
                ],
            ],

            'labels' => $serviceCounts->keys()->all(),
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
<?php

namespace App\Filament\Widgets;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Filament\Widgets\ChartWidget;

class JobStatusChart extends ChartWidget
{
    protected ?string $heading = 'Job Status Chart';

    // Maps Filament semantic color names to actual hex codes for Chart.js
    protected function resolveColor(string $color): string
    {
        return match ($color) {
            'gray' => 'rgb(107, 114, 128)',
            'warning' => 'rgb(245, 158, 11)',
            'info' => 'rgb(59, 130, 246)',
            'primary' => 'rgb(99, 102, 241)',
            'success' => 'rgb(34, 197, 94)',
            'danger' => 'rgb(239, 68, 68)',
            default => 'rgb(156, 163, 175)',
        };
    }

    protected function getData(): array
    {
        $statusCounts = JobOrder::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $labels = [];
        $data = [];
        $colors = [];

        foreach (Status::cases() as $status) {
            $labels[] = $status->getLabel();
            $data[] = (int) ($statusCounts[$status->value] ?? 0);
            $colors[] = $this->resolveColor($status->getColor());
        }

        return [
            'datasets' => [
                [
                    'label' => 'Job Orders',
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],

            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
<?php

namespace App\Filament\Widgets;

use App\Enums\Payment\Method;
use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class PaymentMethodChart extends ChartWidget
{
    protected ?string $heading = 'Payment Method Chart';

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
        $methodCounts = Payment::query()
            ->selectRaw('method, COUNT(*) as total')
            ->groupBy('method')
            ->pluck('total', 'method');

        $labels = [];
        $data = [];
        $colors = [];

        foreach (Method::cases() as $method) {
            $labels[] = $method->getLabel();
            $data[] = (int) ($methodCounts[$method->value] ?? 0);
            $colors[] = $this->resolveColor($method->getColor());
        }

        return [
            'datasets' => [
                [
                    'label' => 'Payments',
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
<?php

namespace App\Filament\Exports;

use App\Models\JobOrder;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Str;

class JobOrderExporter extends Exporter
{
    protected static ?string $model = JobOrder::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('reference_number'),
            ExportColumn::make('customer.name'),
            ExportColumn::make('device.id'),
            ExportColumn::make('technician.name'),
            ExportColumn::make('status'),
            ExportColumn::make('received_at'),
            ExportColumn::make('scheduled_at'),
            ExportColumn::make('completed_at'),
            ExportColumn::make('released_at'),
            ExportColumn::make('estimate_total'),
            ExportColumn::make('paid_total'),
            ExportColumn::make('intake_notes'),
            ExportColumn::make('release_notes'),
            ExportColumn::make('received_images'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your job order export has completed and ' . Str::of('row')->counted($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Str::of('row')->counted($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

<?php

namespace App\Filament\Widgets;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ActiveRepairsTable extends TableWidget
{
    protected static ?string $heading = 'Active Repairs';

    protected int|string|array $columnSpan = 'full';

    protected const ACTIVE_STATUSES = [
        Status::Diagnosing,
        Status::WaitingApproval,
        Status::WaitingParts,
        Status::Repairing,
        Status::Testing,
    ];

    public function table(Table $table): Table
    {
        return $table

            ->query(function () {
                return JobOrder::query()
                    ->with([
                        'customer',
                        'device.brand',
                        'technician',
                    ])
                    ->whereIn('status', self::ACTIVE_STATUSES)
                    ->orderByDesc('received_at');
            })

            ->columns([

                TextColumn::make('reference_number')
                    ->label('JO #')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('device_display')
                    ->label('Device')
                    ->state(fn (JobOrder $record) => sprintf(
                        '%s %s',
                        $record->device->brand->name,
                        $record->device->model,
                    ))
                    ->searchable([
                        'devices.model',
                    ]),

                TextColumn::make('technician.name')
                    ->label('Technician')
                    ->placeholder('Unassigned')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('inventory_usages_count')
                    ->label('Parts')
                    ->counts('inventoryUsages')
                    ->badge()
                    ->color('warning'),

                TextColumn::make('received_at')
                    ->label('Received')
                    ->since()
                    ->tooltip(fn (JobOrder $record) =>
                        optional($record->received_at)
                            ?->format('M d, Y h:i A')
                    ),

            ])

            ->recordActions([

                ViewAction::make(),

            ])

            ->defaultPaginationPageOption(10)

            ->paginated([10]);
    }
}
<?php

namespace App\Filament\Widgets;

use App\Models\JobOrder;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentJobOrders extends TableWidget
{
    protected static ?string $heading = 'Recent Job Orders';

    protected int|string|array $columnSpan = 'full';

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
                    ->latest('received_at');
            })

            ->columns([

                TextColumn::make('reference_number')
                    ->label('JO #')
                    ->weight('bold')
                    ->copyable()
                    ->searchable()
                    ->sortable(),

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

                TextColumn::make('estimate_total')
                    ->label('Estimate')
                    ->money('PHP'),

                TextColumn::make('received_at')
                    ->label('Received')
                    ->since()
                    ->tooltip(fn (JobOrder $record) => optional($record->received_at)
                        ?->format('M d, Y h:i A'))
                    ->sortable(),

            ])

            ->recordActions([

                ViewAction::make(),

            ])

            ->defaultPaginationPageOption(10)

            ->paginated([10]);
    }
}
<?php

namespace App\Filament\Resources\JobOrders\Tables;

use App\Enums\JobOrder\Status;
use App\Filament\Actions\JobOrderActions;
use App\Models\JobOrder;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JobOrdersTable
{
    public static function configure(Table $table): Table
    {
        $userTimezone = getModelTimezone(auth()->user());

        return $table

            ->defaultSort('created_at', 'desc')

            ->columns([

                TextColumn::make('reference_number')
                    ->label('JO #')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

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
                    ])
                    ->sortable(),

                TextColumn::make('technician.name')
                    ->label('Technician')
                    ->placeholder('Unassigned')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn ($state) => $state->color()),

                TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->state(fn (JobOrder $record) => match (true) {

                        $record->paid_total == 0 => 'Unpaid',

                        $record->paid_total < $record->estimate_total => 'Partial',

                        default => 'Paid',
                    })
                    ->color(fn (string $state) => match ($state) {

                        'Unpaid' => 'danger',

                        'Partial' => 'warning',

                        'Paid' => 'success',

                    }),

                TextColumn::make('estimate_total')
                    ->label('Estimate')
                    ->money('PHP')
                    ->sortable(),

                TextColumn::make('paid_total')
                    ->label('Paid')
                    ->money('PHP')
                    ->sortable(),

                TextColumn::make('balance_due')
                    ->label('Balance')
                    ->state(fn (JobOrder $record) => $record->balanceDue())
                    ->money('PHP')
                    ->weight('bold')
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'success')
                    ->sortable(
                        query: fn (Builder $query, string $direction) =>
                            $query->orderByRaw(
                                "(estimate_total - paid_total) {$direction}"
                            )
                    ),

                TextColumn::make('services_count')
                    ->label('Services')
                    ->counts('services')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('inventory_usages_count')
                    ->label('Parts')
                    ->counts('inventoryUsages')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                TextColumn::make('payments_count')
                    ->label('Payments')
                    ->counts('payments')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                TextColumn::make('received_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(
                        fn ($state) => $state
                            ? $state
                                ->timezone($userTimezone)
                                ->format('M d, Y g:i A')
                            : null
                    ),

            ])

            ->filters([

                SelectFilter::make('status')
                    ->options(Status::array()),

                SelectFilter::make('payment_status')
                    ->label('Payment')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                    ])
                    ->query(function (Builder $query, array $data): Builder {

                        return match ($data['value'] ?? null) {

                            'unpaid' => $query
                                ->where('paid_total', 0),

                            'partial' => $query
                                ->where('paid_total', '>', 0)
                                ->whereColumn(
                                    'paid_total',
                                    '<',
                                    'estimate_total'
                                ),

                            'paid' => $query
                                ->whereColumn(
                                    'paid_total',
                                    '>=',
                                    'estimate_total'
                                ),

                            default => $query,
                        };
                    }),

                SelectFilter::make('technician')
                    ->relationship('technician', 'name'),

            ])

            ->recordActions([

                ViewAction::make(),

                JobOrderActions::make(),

            ])

            ->toolbarActions([

                BulkActionGroup::make([

                    // Assign Technician
                    // Print Job Orders
                    // Export
                    // Bulk Status Update

                ]),

            ]);
    }
}
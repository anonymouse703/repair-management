<?php

namespace App\Filament\Resources\JobOrders\Tables;

use App\Enums\JobOrder\Status;
use App\Filament\Actions\JobOrderActions;
use App\Models\JobOrder;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                    ->copyable(),

                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('device')
                    ->label('Device')
                    ->formatStateUsing(fn (JobOrder $record) => sprintf(
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
                    ->money('PHP')
                    ->state(fn (JobOrder $record) => $record->balanceDue())
                    ->color(fn ($state) => $state <= 0 ? 'success' : 'danger')
                    ->sortable(
                        query: fn (Builder $query, string $direction) =>
                            $query->orderByRaw(
                                "(estimate_total - paid_total) {$direction}"
                            )
                    ),

                TextColumn::make('received_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state
                            ? $state
                                ->timezone($userTimezone)
                                 ->format('F j, Y g:i A')
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
                        'partial' => 'Partially Paid',
                        'paid' => 'Fully Paid',
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

            ])

            ->recordActions([

               JobOrderActions::make(),
               
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
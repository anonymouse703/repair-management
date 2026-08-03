<?php

namespace App\Filament\Widgets;

use App\Models\JobOrder;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class OutstandingBalancesTable extends TableWidget
{
    protected static ?string $heading = 'Outstanding Balances';

    public function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                /** @var Builder $query */
                $query = JobOrder::query()
                    ->with(['customer', 'device.brand'])
                    ->whereColumn('estimate_total', '>', 'paid_total')
                    ->latest('received_at');

                return $query;
            })
            ->columns([
                TextColumn::make('reference_number')
                    ->label('Reference #')
                    ->searchable(),

                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('device.brand.name')
                    ->label('Brand'),

                TextColumn::make('device.model')
                    ->label('Model'),

                TextColumn::make('estimate_total')
                    ->label('Estimate')
                    ->money('PHP'),

                TextColumn::make('paid_total')
                    ->label('Paid')
                    ->money('PHP'),

                TextColumn::make('balance_due')
                    ->label('Balance Due')
                    ->state(fn (JobOrder $record): float => $record->balanceDue())
                    ->money('PHP')
                    ->color('danger'),

                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ])
            ->defaultPaginationPageOption(10)
            ->paginated([10]);
    }
}
<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentPayments extends TableWidget
{
    protected static ?string $heading = 'Recent Payments';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Payment::query()
                    ->with(['jobOrder', 'jobOrder.customer'])
                    ->latest('paid_at')
            )
            ->columns([
                TextColumn::make('jobOrder.reference_number')
                    ->label('Job Order #')
                    ->searchable(),

                TextColumn::make('jobOrder.customer.name')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('PHP'),

                TextColumn::make('method')
                    ->label('Method')
                    ->badge(),

                TextColumn::make('paid_at')
                    ->label('Paid At')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
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
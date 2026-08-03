<?php

namespace App\Filament\Widgets;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ReadyForPickupTable extends TableWidget
{
    protected static ?string $heading = 'Ready for Pickup';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => JobOrder::query()
                    ->with(['customer', 'device.brand'])
                    ->where('status', Status::ReadyForPickup)
                    ->latest('completed_at')
            )
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

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('completed_at')
                    ->label('Ready Since')
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
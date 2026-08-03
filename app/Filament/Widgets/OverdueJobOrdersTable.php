<?php

namespace App\Filament\Widgets;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class OverdueJobOrdersTable extends TableWidget
{
    protected static ?string $heading = 'Overdue Job Orders';

    public function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                /** @var Builder $query */
                $query = JobOrder::query()
                    ->with(['customer', 'device.brand', 'technician'])
                    ->whereNotNull('scheduled_at')
                    ->where('scheduled_at', '<', now())
                    ->whereNotIn('status', [
                        Status::Released,
                        Status::Cancelled,
                    ])
                    ->orderBy('scheduled_at');

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

                TextColumn::make('technician.name')
                    ->label('Technician'),

                TextColumn::make('scheduled_at')
                    ->label('Expected By')
                    ->dateTime('M d, Y h:i A')
                    ->color('danger')
                    ->sortable(),

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
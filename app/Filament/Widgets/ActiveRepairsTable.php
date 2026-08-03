<?php

namespace App\Filament\Widgets;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ActiveRepairsTable extends TableWidget
{
    protected static ?string $heading = 'Active Repairs';

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
            ->query(function (): Builder {
                /** @var Builder $query */
                $query = JobOrder::query()
                    ->with(['customer', 'device.brand', 'technician'])
                    ->whereIn('status', self::ACTIVE_STATUSES)
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

                TextColumn::make('technician.name')
                    ->label('Technician'),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('received_at')
                    ->label('Received')
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
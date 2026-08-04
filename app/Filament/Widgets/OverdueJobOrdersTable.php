<?php

namespace App\Filament\Widgets;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class OverdueJobOrdersTable extends TableWidget
{
    protected static ?string $heading = 'Overdue Job Orders';

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
                    ->whereNotNull('scheduled_at')
                    ->where('scheduled_at', '<', now())
                    ->whereNotIn('status', [
                        Status::Released,
                        Status::Cancelled,
                    ])
                    ->orderBy('scheduled_at');
            })

            ->columns([

                TextColumn::make('reference_number')
                    ->label('JO #')
                    ->weight('bold')
                    ->copyable()
                    ->searchable(),

                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('device_display')
                    ->label('Device')
                    ->state(fn (JobOrder $record) => sprintf(
                        '%s %s',
                        $record->device->brand->name,
                        $record->device->model,
                    )),

                TextColumn::make('technician.name')
                    ->label('Technician')
                    ->placeholder('Unassigned'),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('scheduled_at')
                    ->label('Expected')
                    ->dateTime('M d, Y h:i A')
                    ->color('danger')
                    ->sortable(),

                TextColumn::make('days_overdue')
                    ->label('Overdue')
                    ->state(fn (JobOrder $record) => $record->scheduled_at
                        ? $record->scheduled_at->diffForHumans(now(), [
                            'parts' => 2,
                            'short' => true,
                            'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW,
                        ])
                        : '-')
                    ->badge()
                    ->color('danger'),

            ])

            ->recordActions([

                ViewAction::make(),

            ])

            ->defaultPaginationPageOption(10)

            ->paginated([10]);
    }
}
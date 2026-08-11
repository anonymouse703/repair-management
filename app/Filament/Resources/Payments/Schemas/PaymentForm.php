<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Enums\JobOrder\Status;
use App\Enums\Payment\Method;
use App\Models\JobOrder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('job_order_id')
                    ->label('Job Order')
                    ->relationship(
                        name: 'jobOrder',
                        modifyQueryUsing: fn (Builder $query) => $query
                            ->whereIn('status', [
                                Status::ReadyForPickup,
                                Status::Released,
                            ])
                            ->orderByDesc('id')
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (JobOrder $record) => sprintf(
                            '%s • %s • %s',
                            $record->reference_number,
                            $record->customer->name,
                            $record->device->model,
                        )
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(
                        function (?string $state, Set $set) {
                            if (blank($state)) {
                                $set('amount', null);

                                return;
                            }

                            $jobOrder = JobOrder::query()
                                ->select([
                                    'id',
                                    'estimate_total',
                                    'paid_total',
                                ])
                                ->findOrFail($state);

                            $set(
                                'amount',
                                number_format(
                                    $jobOrder->balanceDue(),
                                    2,
                                    '.',
                                    ''
                                )
                            );
                        }
                    ),

                TextInput::make('amount')
                    ->label('Amount')
                    ->required()
                    ->numeric()
                    ->prefix('₱')
                    ->minValue(0.01),

                Select::make('method')
                    ->label('Payment Method')
                    ->options(Method::array())
                    ->required(),

                DateTimePicker::make('paid_at')
                    ->label('Paid at')
                    ->default(now())
                    ->seconds(false)
                    ->native(false)
                    ->required(),

                Textarea::make('notes')
                    ->label('Notes')
                    ->columnSpanFull()
                    ->placeholder('Optional notes about this payment')
                    ->rows(4),

            ]);
    }
}
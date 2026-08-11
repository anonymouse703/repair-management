<?php

namespace App\Filament\Resources\JobOrders\Schemas;

use App\Enums\Device\Status as DeviceStatus;
use App\Enums\User\Role;
use App\Models\Device;
use App\Models\JobOrder;
use App\Models\Service;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class JobOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('device_id', null);
                    })
                    ->required()
                    ->columnSpanFull(),

                Select::make('device_id')
                    ->label('Device')
                    ->relationship(
                        name: 'device',
                        modifyQueryUsing: function (
                            Builder $query,
                            Get $get,
                            ?JobOrder $record
                        ) {
                            $customerId = $get('customer_id');

                            if (blank($customerId)) {
                                return $query->whereRaw('1 = 0');
                            }

                            return $query
                                ->where('customer_id', $customerId)
                                ->where(
                                    'status',
                                    DeviceStatus::Active
                                )
                                ->whereDoesntHave(
                                    'jobOrders',
                                    function (Builder $query) use ($record) {

                                        // Ignore the current Job Order when editing.
                                        if ($record) {
                                            $query->where(
                                                'id',
                                                '!=',
                                                $record->id
                                            );
                                        }

                                        // Device cannot be selected if it has
                                        // another active Job Order.
                                        $query->whereNotIn(
                                            'status',
                                            [
                                                \App\Enums\JobOrder\Status::Released,
                                                \App\Enums\JobOrder\Status::Cancelled,
                                            ]
                                        );
                                    }
                                )
                                ->orderBy('model');
                        }
                    )
                    ->getOptionLabelFromRecordUsing(
                        function (Device $device) {
                            return sprintf(
                                '%s %s',
                                $device->brand->name,
                                $device->model,
                            );
                        }
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(
                        fn (Get $get) => blank(
                            $get('customer_id')
                        )
                    ),

                Select::make('technician_id')
                    ->label('Assigned Technician')
                    ->relationship(
                        name: 'technician',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (
                            Builder $query
                        ) => $query
                            ->where(
                                'role',
                                Role::Technician
                            )
                            ->where(
                                'is_active',
                                true
                            )
                            ->orderBy('name'),
                    )
                    ->searchable()
                    ->preload()
                    ->placeholder('Assign later'),

                DateTimePicker::make('received_at')
                    ->default(now())
                    ->live()
                    ->required()
                    ->afterStateUpdated(
                        function (
                            Get $get,
                            Set $set,
                            $state
                        ) {
                            if (
                                $get('scheduled_at') &&
                                $get('scheduled_at') < $state
                            ) {
                                $set(
                                    'scheduled_at',
                                    null
                                );
                            }

                            if (
                                $get('completed_at') &&
                                $get('completed_at') < $state
                            ) {
                                $set(
                                    'completed_at',
                                    null
                                );
                            }
                        }
                    ),

                DatePicker::make('scheduled_at')
                    ->label('Scheduled at')
                    ->minDate(
                        fn (Get $get) => $get(
                            'received_at'
                        )
                    )
                    ->live(),

                Repeater::make('serviceUsages')
                    ->label('Services')
                    ->relationship('serviceUsages')
                    ->schema([

                        Select::make('service_id')
                            ->label('Service')
                            ->options(
                                fn () => Service::query()
                                    ->where('active', true)
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->afterStateUpdated(
                                function (
                                    Get $get,
                                    Set $set,
                                    $state
                                ) {
                                    if (blank($state)) {
                                        $set('price', 0);

                                        static::updateEstimateTotal(
                                            $get,
                                            $set
                                        );

                                        return;
                                    }

                                    $service = Service::find($state);

                                    $set(
                                        'price',
                                        $service
                                            ? (float) $service->price
                                            : 0
                                    );

                                    static::updateEstimateTotal(
                                        $get,
                                        $set
                                    );
                                }
                            ),

                        TextInput::make('quantity')
                            ->label('Qty')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->default(1)
                            ->required()
                            ->live()
                            ->afterStateUpdated(
                                fn (Get $get, Set $set) =>
                                    static::updateEstimateTotal($get, $set)
                            ),

                        TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('₱')
                            ->required()
                            ->live()
                            ->afterStateUpdated(
                                fn (Get $get, Set $set) =>
                                    static::updateEstimateTotal($get, $set)
                            ),

                    ])
                    ->columns(3)
                    ->defaultItems(0)
                    ->addActionLabel('Add Service')
                    ->reorderable(false)
                    ->collapsible()
                    ->columnSpanFull()
                    ->live()
                    ->afterStateUpdated(
                        fn (Get $get, Set $set) =>
                            static::updateEstimateTotal($get, $set)
                    ),

                TextInput::make('estimate_total')
                    ->label('Estimated Total')
                    ->numeric()
                    ->prefix('₱')
                    ->readOnly()
                    ->dehydrated()
                    ->default(0)
                    ->required(),

                Textarea::make('intake_notes')
                    ->label('Intake Notes')
                    ->rows(4)
                    ->columnSpanFull(),

                Textarea::make('release_notes')
                    ->label('Release Notes')
                    ->rows(4)
                    ->columnSpanFull(),

                FileUpload::make('received_images')
                    ->label('Intake Images')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->maxSize(5120)
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ])
                    ->directory('job-order-images')
                    ->visibility('public')
                    ->preserveFilenames(false)
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull()

            ]);
    }

    protected static function updateEstimateTotal(
        Get $get,
        Set $set
    ): void {
        $services = $get('serviceUsages') ?? [];

        $total = collect($services)->sum(function (array $service) {
            $quantity = (int) ($service['quantity'] ?? 0);
            $price = (float) ($service['price'] ?? 0);

            return $quantity * $price;
        });

        $set('estimate_total', number_format($total, 2, '.', ''));
    }
}
<?php

namespace App\Filament\Resources\JobOrders\Schemas;

use App\Enums\Device\Status;
use App\Models\Device;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
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
                    ->required(),

                Select::make('device_id')
                    ->label('Device')
                    ->relationship(
                        name: 'device',
                        modifyQueryUsing: fn (Builder $query, Get $get) => $query
                            ->where('customer_id', $get('customer_id'))
                            ->orderBy('model')
                    )
                    ->getOptionLabelFromRecordUsing(function (Device $device) {
                        return sprintf(
                            '%s %s%s',
                            $device->brand->name,
                            $device->model,
                            $device->status === Status::Archived
                                ? ' (Archived)'
                                : ''
                        );
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(fn (Get $get) => blank($get('customer_id'))),

                Select::make('technician_id')
                    ->relationship('technician', 'name')
                    ->label('Technician'),

                DatePicker::make('received_at')
                    ->default(now())
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        if ($get('scheduled_at') && $get('scheduled_at') < $state) {
                            $set('scheduled_at', null);
                        }

                        if ($get('completed_at') && $get('completed_at') < $state) {
                            $set('completed_at', null);
                        }
                    }),

                DatePicker::make('scheduled_at')
                    ->label('Scheduled at')
                    ->minDate(fn (Get $get) => $get('received_at'))
                    ->live(),

                DatePicker::make('completed_at')
                    ->label('Completed at')
                    ->minDate(fn (Get $get) => $get('scheduled_at') ?: $get('received_at')),

                TextInput::make('estimate_total')
                    ->required()
                    ->numeric()
                    ->prefix('₱'),

                Select::make('services')
                    ->relationship('services', 'name')
                    ->label('Services')
                    ->multiple(),

                Textarea::make('intake_notes')
                    ->rows(4),

                Textarea::make('release_notes')
                    ->rows(4),

                FileUpload::make('received_images')
                    ->label('Intake Images')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->maxSize(5120) // 5 MB
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ])
                    ->directory('job-order-images')
                    ->visibility('private')
                    ->preserveFilenames(false)
                    ->downloadable()
                    ->openable()
            ]);
    }
}

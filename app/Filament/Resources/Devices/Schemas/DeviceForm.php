<?php

namespace App\Filament\Resources\Devices\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class DeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required(),

                Select::make('device_type_id')
                    ->label('Device Type')
                    ->relationship(
                        name: 'type',
                        titleAttribute: 'name'
                    )
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                        Textarea::make('description')
                            ->rows(4),
                    ])
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('brand_id')
                    ->label('Brand')
                    ->relationship(
                        name: 'brand',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query
                            ->where('active', true)
                            ->orderBy('sort_order')
                            ->orderBy('name')
                    )
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                        Textarea::make('description')
                            ->rows(4),
                    ])
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('model')
                    ->maxLength(255),

                TextInput::make('serial_number')
                    ->maxLength(255),

                TextInput::make('imei')
                    ->maxLength(255),

                Textarea::make('notes')
                    ->columnSpanFull()
                    ->rows(4),
            ]);
    }
}

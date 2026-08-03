<?php

namespace App\Filament\Resources\InventoryItems\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InventoryItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('sku')
                    ->required()
                    ->maxLength(255),

                TextInput::make('quantity')
                    ->required()
                    ->numeric(),

                TextInput::make('cost')
                    ->numeric()
                    ->prefix('$'),

                TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),

                TextInput::make('location')
                    ->maxLength(255),

                TextInput::make('reorder_level')
                    ->numeric(),

                Toggle::make('active')
                    ->label('Active')
                    ->default(true),

                Textarea::make('notes')
                    ->rows(4),
            ]);
    }
}

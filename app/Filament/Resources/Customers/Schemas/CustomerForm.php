<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->required()
                    ->email()
                    ->unique()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->tel()
                    ->maxLength(50),

                TextInput::make('company')
                    ->maxLength(255),

                TextInput::make('address')
                    ->maxLength(500),

                TextInput::make('preferred_contact')
                    ->label('Preferred contact')
                    ->maxLength(255),

                Textarea::make('notes')
                    ->columnSpanFull()
                    ->rows(4),
            ]);
    }
}

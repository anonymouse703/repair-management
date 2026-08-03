<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Enums\Payment\Method;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('job_order_id')
                    ->relationship('jobOrder', 'id')
                    ->required()
                    ->label('Job order'),

                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('$'),

                Select::make('method')
                    ->options(Method::array())
                    ->required(),

                TextInput::make('reference')
                    ->maxLength(255),

                DatePicker::make('paid_at')
                    ->label('Paid at'),

                Textarea::make('notes')
                    ->rows(4),
            ]);
    }
}

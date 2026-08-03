<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        $userTimezone = getModelTimezone(auth()->user());

        return $table
            ->columns([
                TextColumn::make('jobOrder.reference_number')
                    ->label('Job order'),

                TextColumn::make('amount')
                    ->prefix('₱')
                    ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 2) : null),

                TextColumn::make('method')
                    ->sortable(),

                TextColumn::make('paid_at')
                    ->label('Paid at')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state
                            ? $state
                                ->timezone($userTimezone)
                                 ->format('F j, Y g:i A')
                            : null
                    ),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}

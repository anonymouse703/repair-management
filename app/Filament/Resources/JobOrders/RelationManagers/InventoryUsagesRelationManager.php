<?php

namespace App\Filament\Resources\JobOrders\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventoryUsagesRelationManager extends RelationManager
{
    protected static string $relationship = 'inventoryUsages';

    protected static ?string $title = 'Parts Used';

    protected static ?string $pluralLabel = 'Parts Used';

    public function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('inventoryItem.name')
                    ->label('Part')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('quantity')
                    ->label('Qty')
                    ->sortable(),

                TextColumn::make('inventoryItem.unit')
                    ->label('Unit')
                    ->badge(),

                TextColumn::make('cost_at_time')
                    ->label('Unit Cost')
                    ->money('PHP')
                    ->sortable(),

                TextColumn::make('price_at_time')
                    ->label('Selling Price')
                    ->money('PHP')
                    ->sortable(),

                TextColumn::make('usedBy.name')
                    ->label('Added By')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('notes')
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Used At')
                    ->dateTime()
                    ->sortable(),

            ])
            ->filters([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
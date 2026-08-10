<?php

namespace App\Filament\Resources\InventoryItems\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventoryItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('sku')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('quantity'),

                TextColumn::make('price')
                    ->money('PHP'),

                IconColumn::make('active')
                    ->label('Active'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    // ViewAction::make(),
                    EditAction::make(),
                    Action::make('toggleStatus')
                        ->label(fn ($record) => $record->active ? 'Set Inactive' : 'Set Active')
                        ->icon(fn ($record) => $record->active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn ($record) => $record->active ? 'danger' : 'success')
                        ->requiresConfirmation()
                        ->modalHeading(fn ($record) => $record->active ? 'Set as Inactive?' : 'Set as Active?')
                        ->modalDescription(fn ($record) => $record->active 
                            ? 'This will deactivate the record.' 
                            : 'This will activate the record.')
                        ->action(function ($record) {
                            $record->update(['active' => !$record->active]);
                        }),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Customers\Tables;

use App\Filament\Exports\CustomerExporter;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->headerActions([
                    ExportAction::make()
                        ->exporter(CustomerExporter::class),
                ])
                
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('phone')
                    ->sortable(),

                TextColumn::make('company')
                    ->sortable(),

                IconColumn::make('active')
                    ->label('Active'),
            ])
            ->filters([
                Filter::make('active')
                    ->query(fn ($query) => $query->where('active', true))
                    ->label('Active'),
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

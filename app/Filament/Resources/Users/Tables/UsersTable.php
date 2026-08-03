<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\User\Role;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\Icon as ComponentsIcon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Laravel\Mcp\Schema\Icon;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('username')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('role')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state?->label())
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),

                SelectFilter::make('role')
                    ->label('Role')
                    ->options(Role::array()),
            ])
            ->recordActions([
                ActionGroup::make([
                    // ViewAction::make(),
                    EditAction::make(),
                    Action::make('toggleStatus')
                        ->label(fn ($record) => $record->is_active ? 'Set Inactive' : 'Set Active')
                        ->icon(fn ($record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn ($record) => $record->is_active ? 'danger' : 'success')
                        ->requiresConfirmation()
                        ->modalHeading(fn ($record) => $record->is_active ? 'Set as Inactive?' : 'Set as Active?')
                        ->modalDescription(fn ($record) => $record->is_active 
                            ? 'This will deactivate the record.' 
                            : 'This will activate the record.')
                        ->action(function ($record) {
                            $record->update(['is_active' => !$record->is_active]);
                        }),
                ]),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}

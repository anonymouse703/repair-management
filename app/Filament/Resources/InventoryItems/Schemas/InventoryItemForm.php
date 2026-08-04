<?php

namespace App\Filament\Resources\InventoryItems\Schemas;

use App\Enums\Inventory\Category;
use App\Enums\Inventory\Unit;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class InventoryItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Grid::make(2)
                    ->schema([

                        TextInput::make('name')
                            ->label('Item Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Select::make('category')
                            ->options(Category::array())
                            ->live()
                            ->required(),

                        Select::make('unit')
                            ->options(Unit::array())
                            ->required()
                            ->default(Unit::Piece),

                        TextInput::make('quantity')
                            ->label('Current Stock')
                            ->numeric()
                            ->integer()
                            ->default(0)
                            ->required(),

                        TextInput::make('reorder_level')
                            ->numeric()
                            ->default(5)
                            ->visible(fn (Get $get) => in_array(
                                $get('category'),
                                [
                                    Category::RepairPart->value,
                                    Category::Consumable->value,
                                ],
                                true,
                            )),

                        TextInput::make('cost')
                            ->label('Unit Cost')
                            ->numeric()
                            ->prefix('₱')
                            ->default(0),

                        TextInput::make('price')
                            ->label('Selling Price')
                            ->numeric()
                            ->prefix('₱')
                            ->default(0),

                        TextInput::make('location')
                            ->placeholder('Shelf A-01')
                            ->maxLength(255),

                        Toggle::make('active')
                            ->label('Active')
                            ->default(true),

                    ]),

                Textarea::make('notes')
                    ->columnSpanFull()
                    ->rows(4)
                    ->placeholder('Optional notes...'),

            ]);
    }
}

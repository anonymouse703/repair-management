<?php

namespace App\Enums\Inventory;

use App\Enums\Traits\EnumToArray;
use Filament\Support\Contracts\HasLabel;

enum Unit: string implements HasLabel
{
    use EnumToArray;

    // Count
    case Piece = 'pcs';
    case Set = 'set';
    case Pair = 'pair';
    case Box = 'box';
    case Pack = 'pack';
    case Roll = 'roll';

    // Weight
    case Gram = 'g';
    case Kilogram = 'kg';

    // Volume
    case Milliliter = 'ml';
    case Liter = 'L';

    // Length
    case Meter = 'm';
    case Centimeter = 'cm';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Piece => 'Pieces (pcs)',
            self::Set => 'Set',
            self::Pair => 'Pair',
            self::Box => 'Box',
            self::Pack => 'Pack',
            self::Roll => 'Roll',

            self::Gram => 'Gram (g)',
            self::Kilogram => 'Kilogram (kg)',

            self::Milliliter => 'Milliliter (mL)',
            self::Liter => 'Liter (L)',

            self::Meter => 'Meter (m)',
            self::Centimeter => 'Centimeter (cm)',
        };
    }
}

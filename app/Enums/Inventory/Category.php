<?php

namespace App\Enums\Inventory;

use App\Enums\Traits\EnumToArray;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Category: string implements HasColor, HasLabel
{
    use EnumToArray;

    case RepairPart = 'repair_part';

    case Consumable = 'consumable';

    case Equipment = 'equipment';

    case Accessory = 'accessory';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::RepairPart => 'Repair Part',
            self::Consumable => 'Consumable',
            self::Equipment => 'Equipment',
            self::Accessory => 'Accessory',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::RepairPart => 'primary',
            self::Consumable => 'warning',
            self::Equipment => 'success',
            self::Accessory => 'gray',
        };
    }

    public function isConsumable(): bool
    {
        return match ($this) {
            self::RepairPart,
            self::Consumable => true,

            default => false,
        };
    }
}

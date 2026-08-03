<?php

namespace App\Enums\Device;

use App\Enums\Traits\EnumToArray;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasLabel, HasColor
{
    use EnumToArray;

    // Device is active and can receive new job orders.
    case Active = 'active';

    // Device has been archived from the system.
    case Archived = 'archived';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Archived => 'Archived',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Archived => 'gray',
        };
    }
}
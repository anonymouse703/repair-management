<?php

namespace App\Enums\Payment;

use App\Enums\Traits\EnumToArray;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Method: string implements HasLabel, HasColor
{
    use EnumToArray;

    case Cash = 'cash';
    case GCash = 'gcash';
    case Maya = 'maya';
    case BankTransfer = 'bank_transfer';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Cash => 'Cash',
            self::GCash => 'GCash',
            self::Maya => 'Maya',
            self::BankTransfer => 'Bank Transfer',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Cash => 'success',
            self::GCash => 'info',
            self::Maya => 'warning',
            self::BankTransfer => 'primary',
        };
    }
}
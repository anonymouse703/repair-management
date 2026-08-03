<?php

namespace App\Enums\JobOrder;

use App\Enums\Traits\EnumToArray;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasLabel, HasColor
{
    use EnumToArray;

    case Received = 'received';
    case Diagnosing = 'diagnosing';
    case WaitingApproval = 'waiting_approval';
    case WaitingParts = 'waiting_parts';
    case Repairing = 'repairing';
    case Testing = 'testing';
    case ReadyForPickup = 'ready_for_pickup';
    case Released = 'released';
    case Cancelled = 'cancelled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Received => 'Received',
            self::Diagnosing => 'Diagnosing',
            self::WaitingApproval => 'Waiting for Approval',
            self::WaitingParts => 'Waiting for Parts',
            self::Repairing => 'Repairing',
            self::Testing => 'Testing',
            self::ReadyForPickup => 'Ready for Pickup',
            self::Released => 'Released',
            self::Cancelled => 'Cancelled',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Received => 'gray',
            self::Diagnosing => 'warning',
            self::WaitingApproval => 'info',
            self::WaitingParts => 'gray',
            self::Repairing => 'primary',
            self::Testing => 'warning',
            self::ReadyForPickup => 'success',
            self::Released => 'success',
            self::Cancelled => 'danger',
        };
    }
}
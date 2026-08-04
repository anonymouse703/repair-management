<?php

namespace App\Enums\User;

use App\Enums\Traits\EnumToArray;

enum Role: string
{
    use EnumToArray;

    case SuperAdmin = 'super_admin';

    case Manager = 'manager';
    case Technician = 'technician';
    case Staff = 'staff';

    case Receptionist = 'receptionist';

    case Cashier = 'cashier';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Manager => 'Manager',
            self::Technician => 'Technician',
            self::Staff => 'Staff',
            self::Receptionist => 'Receptionist',
            self::Cashier => 'Cashier',
        };
    }
}

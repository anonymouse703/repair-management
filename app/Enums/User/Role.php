<?php

namespace App\Enums\User;

use App\Enums\Traits\EnumToArray;

enum Role: string
{
    use EnumToArray;

    case SuperAdmin = 'super_admin';

    case Technician = 'technician';
    case Staff = 'staff';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Technician => 'Technician',
            self::Staff => 'Staff',
        };
    }

}


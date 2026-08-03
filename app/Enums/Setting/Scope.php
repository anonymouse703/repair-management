<?php

namespace App\Enums\Setting;

use App\Enums\Traits\EnumToArray;

enum Scope: string
{
    use EnumToArray;

    case System = "system";
    case App = "app";
    case Admin = "admin";

    public static function public() : array
    {
        return [
            self::System,
            self::App
        ];
    }
}

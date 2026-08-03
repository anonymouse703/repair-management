<?php

namespace App\Enums\Setting;

use App\Enums\Traits\EnumToArray;

enum Type: string
{
    use EnumToArray;

    case Boolean = "boolean";
    case Select = "select";
    case Text = "text";
    case Integer = "integer";
    case Float = "float";
    case DateTime = "datetime";
    case JSON = "json";
}

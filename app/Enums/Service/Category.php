<?php

namespace App\Enums\Service;

use App\Enums\Traits\EnumToArray;

enum Category: string
{
    use EnumToArray;

    case Hardware = 'hardware';

    case Software = 'software';

    case Installation = 'installation';

    case Recovery = 'recovery';

    case Cleaning = 'cleaning';

    case Maintenance = 'maintenance';

    case Upgrade = 'upgrade';

    case Network = 'network';

    case Diagnostic = 'diagnostic';

    case Other = 'other';

}
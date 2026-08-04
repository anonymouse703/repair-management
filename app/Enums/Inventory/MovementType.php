<?php

namespace App\Enums\Inventory;

enum MovementType: string
{
    case Restock = 'restock';

    case Consume = 'consume';

    case Adjustment = 'adjustment';

    case Return = 'return';

    case Transfer = 'transfer';
}

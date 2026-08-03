<?php

namespace App\Enums\Payment;

use App\Enums\Traits\EnumToArray;

enum Method: string
{
    use EnumToArray;

    case Cash = 'cash';
    case GCash = 'gcash';
    case Maya = 'maya';
    case BankTransfer = 'bank_transfer';
}

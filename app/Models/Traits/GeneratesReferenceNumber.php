<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait GeneratesReferenceNumber
{
    protected static function bootGeneratesReferenceNumber(): void
    {
        static::creating(function (Model $model) {

            $prefix = defined(static::class.'::REFERENCE_PREFIX')
                ? static::REFERENCE_PREFIX
                : 'REF';

            $digits = defined(static::class.'::REFERENCE_DIGITS')
                ? static::REFERENCE_DIGITS
                : 6;


            $nextId = (static::max('id') ?? 0) + 1;

            $model->reference_number = sprintf(
                '%s-%0'.$digits.'d',
                $prefix,
                $nextId
            );
        });
    }
}
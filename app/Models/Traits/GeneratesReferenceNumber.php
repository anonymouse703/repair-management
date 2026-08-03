<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait GeneratesReferenceNumber
{
    protected static function bootGeneratesReferenceNumber(): void
    {
        static::creating(function (Model $model) {
            $column = defined(static::class.'::REFERENCE_COLUMN')
                ? static::REFERENCE_COLUMN
                : 'reference_number';

            if (! empty($model->{$column})) {
                return;
            }

            $prefix = defined(static::class.'::REFERENCE_PREFIX')
                ? static::REFERENCE_PREFIX
                : 'REF';

            $digits = defined(static::class.'::REFERENCE_DIGITS')
                ? static::REFERENCE_DIGITS
                : 6;

            $nextId = (static::max($model->getKeyName()) ?? 0) + 1;

            $model->{$column} = sprintf(
                '%s-%0'.$digits.'d',
                $prefix,
                $nextId,
            );
        });
    }
}
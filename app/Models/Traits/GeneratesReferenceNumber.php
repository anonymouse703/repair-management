<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait GeneratesReferenceNumber
{
    protected static function bootGeneratesReferenceNumber(): void
    {
        static::creating(function (Model $model) {

            $column = defined(static::class . '::REFERENCE_COLUMN')
                ? constant(static::class . '::REFERENCE_COLUMN')
                : 'reference_number';

            // Don't overwrite an explicitly supplied reference.
            if (! empty($model->{$column})) {
                return;
            }

            $prefix = defined(static::class . '::REFERENCE_PREFIX')
                ? constant(static::class . '::REFERENCE_PREFIX')
                : 'REF';

            $digits = defined(static::class . '::REFERENCE_DIGITS')
                ? constant(static::class . '::REFERENCE_DIGITS')
                : 6;

            /*
             * The ID is not available yet during `creating`.
             *
             * So get the next ID from the table.
             */
            $nextNumber = ((int) static::query()->max(
                $model->getKeyName()
            )) + 1;

            $model->{$column} = sprintf(
                '%s-%0' . $digits . 'd',
                $prefix,
                $nextNumber
            );
        });
    }
}
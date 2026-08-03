<?php

namespace App\Console\Commands\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

trait HasValidator
{
    protected function validate($value, string $field, array $rules): ?string
    {
        $rules = Arr::wrap($rules);

        $validator = Validator::make([$field => $value], [$field => $rules]);

        if ($validator->fails()) {
            return $validator->errors()->first($field);
        }

        return null;
    }
}

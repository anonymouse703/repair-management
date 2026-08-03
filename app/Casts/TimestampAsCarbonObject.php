<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TimestampAsCarbonObject implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Carbon
    {
        if(is_null($value)) return null;

        if(is_numeric($value)) return Carbon::createFromTimestamp($value);

        return Carbon::parse($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if($value instanceof Carbon) return $value->timestamp;

        if(is_numeric($value)) return $value;

        return Carbon::parse($value)?->timestamp ?? null;
    }
}

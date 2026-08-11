<?php

namespace App\Models\Traits;

trait GeneratesCreatedTs
{
    public static function bootGeneratesCreatedTs(): void
    {
        static::creating(function ($model) {
            $model->created_ts = now()->timestamp;
        });
    }
}

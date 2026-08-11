<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];

    public function jobOrders(): BelongsToMany
    {
        return $this->belongsToMany(
            JobOrder::class,
            'job_order_services'
        )
            ->withPivot([
                'quantity',
                'price_at_time',
            ])
            ->withTimestamps();
    }

    public function usages(): HasMany
    {
        return $this->hasMany(JobOrderService::class);
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
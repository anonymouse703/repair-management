<?php

namespace App\Models;

use App\Cache\JobOrder\JobOrderByReference;
use App\Cache\JobOrder\JobOrdersByCustomerName;
use App\Enums\JobOrder\Status;
use App\Models\Traits\GeneratesReferenceNumber;
use App\Observers\JobOrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([JobOrderObserver::class])]
class JobOrder extends Model
{
    use HasFactory;
    use GeneratesReferenceNumber;

    public const REFERENCE_PREFIX = 'JO';
    public const REFERENCE_DIGITS = 6;

    protected $fillable = [
        'reference_number',
        'customer_id',
        'device_id',
        'technician_id',
        'status',
        'received_at',
        'scheduled_at',
        'completed_at',
        'released_at',
        'estimate_total',
        'paid_total',
        'intake_notes',
        'release_notes',
        'received_images',
    ];

    protected $casts = [
        'status' => Status::class,

        'received_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'released_at' => 'datetime',

        'estimate_total' => 'decimal:2',
        'paid_total' => 'decimal:2',

        'received_images' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'technician_id'
        );
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            'job_order_services'
        )
            ->withPivot([
                'quantity',
                'price',
            ])
            ->withTimestamps();
    }

    public function serviceUsages(): HasMany
    {
        return $this->hasMany(JobOrderService::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function releaseLogs(): HasMany
    {
        return $this->hasMany(JobOrderReleaseLog::class);
    }

    public function inventoryItems(): BelongsToMany
    {
        return $this->belongsToMany(
            InventoryItem::class,
            'job_order_inventories'
        )
            ->withPivot([
                'quantity',
                'cost_at_time',
                'price',
            ])
            ->withTimestamps();
    }

    public function inventoryUsages(): HasMany
    {
        return $this->hasMany(JobOrderInventory::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Financial Helpers
    |--------------------------------------------------------------------------
    */

    public function balanceDue(): float
    {
        return max(
            0,
            (float) $this->estimate_total
                - (float) $this->paid_total
        );
    }

    public function isFullyPaid(): bool
    {
        return (float) $this->paid_total
            >= (float) $this->estimate_total;
    }

    public function isPartiallyPaid(): bool
    {
        return (float) $this->paid_total > 0
            && (float) $this->paid_total
            < (float) $this->estimate_total;
    }

    public function isUnpaid(): bool
    {
        return (float) $this->paid_total === 0.0;
    }

    public function servicesTotal(): float
    {
        return (float) $this->services->sum(function (Service $service) {
            $quantity = (int) ($service->pivot->quantity ?? 1);

            $price = (float) ($service->pivot->price ?? 0);

            return $quantity * $price;
        });
    }

    public function clearCache(): void
    {
        JobOrderByReference::forget($this->reference_number);
        
        if ($this->customer) {
            JobOrdersByCustomerName::forget(
                $this->customer->name
            );
        }
    }

}
<?php

namespace App\Models;

use App\Enums\JobOrder\Status;
use App\Models\Traits\GeneratesReferenceNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOrder extends Model
{
    use GeneratesReferenceNumber;
    use HasFactory;

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
        'received_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'estimate_total' => 'decimal:2',
        'paid_total' => 'decimal:2',
        'received_images' => 'array',
        'status' => Status::class,
    ];

    public function balanceDue(): float
    {
        return max(
            0,
            (float) $this->estimate_total - (float) $this->paid_total
        );
    }

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
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class)
            ->withPivot([
                'quantity',
                'price',
            ])
            ->withTimestamps();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isFullyPaid(): bool
    {
        return $this->paid_total >= $this->estimate_total;
    }

    public function isPartiallyPaid(): bool
    {
        return $this->paid_total > 0 &&
            $this->paid_total < $this->estimate_total;
    }

    public function isUnpaid(): bool
    {
        return $this->paid_total == 0;
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
            ])
            ->withTimestamps();
    }

    public function inventoryUsages()
    {
        return $this->hasMany(JobOrderInventory::class);
    }

}

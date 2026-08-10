<?php

namespace App\Models;

use App\Enums\Inventory\Category;
use App\Enums\Inventory\Unit;
use App\Models\Traits\GeneratesReferenceNumber;
use DomainException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    use HasFactory;
    use GeneratesReferenceNumber;

    public const REFERENCE_PREFIX = 'SKU';

    public const REFERENCE_COLUMN = 'sku';

    public const REFERENCE_DIGITS = 6;

    protected $fillable = [

        'name',
        'sku',
        'category',
        'unit',
        'quantity',
        'cost',
        'price',
        'location',
        'reorder_level',
        'active',
        'notes',

    ];

    protected $casts = [

        'category' => Category::class,
        'unit' => Unit::class,
        'quantity' => 'integer',
        'reorder_level' => 'integer',
        'cost' => 'decimal:2',
        'price' => 'decimal:2',
        'active' => 'boolean',

    ];

    public function isConsumable(): bool
    {
        return $this->category->isConsumable();
    }

    public function deductStock(int $qty): void
    {
        if (! $this->isConsumable()) {
            return;
        }

        if ($qty <= 0) {
            return;
        }

        if ($this->quantity < $qty) {
            throw new DomainException('Insufficient inventory.');
        }

        $this->decrement('quantity', $qty);
    }

    public function addStock(int $qty): void
    {
        if ($qty <= 0) {
            return;
        }

        $this->increment('quantity', $qty);
    }

    public function isLowStock(): bool
    {
        return $this->isConsumable()
            && $this->quantity <= $this->reorder_level;
    }

    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }

    public function jobOrders(): BelongsToMany
    {
        return $this->belongsToMany(
            JobOrder::class,
            'job_order_inventories'
        )
            ->withPivot([
                'quantity',
                'cost_at_time',
            ])
            ->withTimestamps();
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function usages(): HasMany
    {
        return $this->hasMany(JobOrderInventory::class);
    }
}

<?php

namespace App\Models;

use App\Enums\Inventory\MovementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_item_id',
        'type',
        'quantity',
        'before_quantity',
        'after_quantity',
        'reference_type',
        'reference_id',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'type' => MovementType::class,
        'quantity' => 'integer',
        'before_quantity' => 'integer',
        'after_quantity' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    /**
     * The model that caused this movement.
     *
     * Examples:
     * - JobOrder
     * - Purchase
     * - StockAdjustment
     */
    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * User who performed the movement.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isIncoming(): bool
    {
        return in_array(
            $this->type,
            [
                MovementType::Restock,
                MovementType::Adjustment,
                MovementType::Return,
            ],
            true,
        );
    }

    public function isOutgoing(): bool
    {
        return in_array(
            $this->type,
            [
                MovementType::Consume,
                MovementType::Transfer,
            ],
            true,
        );
    }

    public function stockChange(): string
    {
        return $this->isIncoming()
            ? '+'.$this->quantity
            : '-'.$this->quantity;
    }
}

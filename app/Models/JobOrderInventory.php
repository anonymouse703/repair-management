<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobOrderInventory extends Model
{
    use HasFactory;

    protected $table = 'job_order_inventories';

    protected $fillable = [
        'job_order_id',
        'inventory_item_id',
        'technician_id',
        'quantity',
        'cost_at_time',
        'price_at_time',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'cost_at_time' => 'decimal:2',
        'price_at_time' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function jobOrder(): BelongsTo
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function usedBy()
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function totalCost(): float
    {
        return (float) $this->cost_at_time * $this->quantity;
    }

    public function totalPrice(): float
    {
        return (float) $this->price_at_time * $this->quantity;
    }

    public function profit(): float
    {
        return $this->totalPrice() - $this->totalCost();
    }
}

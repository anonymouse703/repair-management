<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'quantity',
        'cost',
        'price',
        'location',
        'reorder_level',
        'active',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'reorder_level' => 'integer',
        'cost' => 'decimal:2',
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];
}

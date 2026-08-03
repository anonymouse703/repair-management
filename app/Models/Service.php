<?php

namespace App\Models;

use App\Enums\Service\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'cost',
        'category',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'category' => Category::class,
    ];

    public function jobOrders(): BelongsToMany
    {
        return $this->belongsToMany(JobOrder::class)
            ->withPivot(['quantity', 'price'])
            ->withTimestamps();
    }
}

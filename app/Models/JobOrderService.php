<?php

namespace App\Models;

use App\Enums\JobOrderService\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobOrderService extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_order_id',
        'service_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'status' => Status::class,
    ];

    public function jobOrder(): BelongsTo
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function subtotal(): float
    {
        return $this->quantity * (float) $this->price;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobOrderReleaseLog extends Model
{
    protected $fillable = [
        'job_order_id',
        'released_by',
        'balance_at_release',
        'reason',
        'released_at',
    ];

    protected $casts = [
        'balance_at_release' => 'decimal:2',
        'released_at' => 'datetime',
    ];

    public function jobOrder(): BelongsTo
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function releasedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'released_by');
    }
}

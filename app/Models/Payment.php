<?php

namespace App\Models;

use App\Models\Traits\GeneratesReferenceNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    use GeneratesReferenceNumber;

    public const REFERENCE_PREFIX = 'PAY';
    public const REFERENCE_DIGITS = 6;
    public const REFERENCE_COLUMN = 'reference';

    protected $fillable = [
        'job_order_id',
        'amount',
        'method',
        'reference',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saved(function (Payment $payment) {
            $payment->syncPaidTotal();
        });

        static::deleted(function (Payment $payment) {
            $payment->syncPaidTotal();
        });
    }

    protected function syncPaidTotal(): void
    {
        $jobOrder = $this->jobOrder;

        if (! $jobOrder) {
            return;
        }

        $jobOrder->updateQuietly([
            'paid_total' => $jobOrder->payments()->sum('amount'),
        ]);
    }

    public function jobOrder(): BelongsTo
    {
        return $this->belongsTo(JobOrder::class);
    }
}
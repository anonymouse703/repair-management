<?php

namespace App\Actions\Payment;

use App\Models\JobOrder;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use DomainException;

class RecordPayment
{
    public function handle(
        JobOrder $jobOrder,
        float $amount,
        string $method,
        ?string $reference = null,
        ?string $notes = null,
    ): Payment {
        if ($amount <= 0) {
            throw new DomainException('Payment amount must be greater than zero.');
        }

        return DB::transaction(function () use (
            $jobOrder,
            $amount,
            $method,
            $reference,
            $notes
        ) {
            $payment = $jobOrder->payments()->create([
                'amount' => $amount,
                'method' => $method,
                'reference' => $reference,
                'notes' => $notes,
                'paid_at' => now(),
            ]);

            $jobOrder->update([
                'paid_total' => $jobOrder->payments()->sum('amount'),
                'balance_due' => max(
                    0,
                    $jobOrder->estimate_total - $jobOrder->payments()->sum('amount')
                ),
            ]);

            return $payment;
        });
    }
}

<?php

namespace App\Actions\Payment;

use App\Models\JobOrder;
use App\Models\Payment;
use DomainException;
use Illuminate\Support\Facades\DB;

class RecordPayment
{
    public function handle(
        JobOrder $jobOrder,
        float $amount,
        string $method,
        ?string $reference = null,
        ?string $notes = null,
        ?\DateTimeInterface $paidAt = null,
    ): Payment {
        if ($amount <= 0) {
            throw new DomainException(
                'Payment amount must be greater than zero.'
            );
        }

        $balance = $jobOrder->balanceDue();

        if ($amount > $balance) {
            throw new DomainException(
                'Payment amount cannot exceed the outstanding balance.'
            );
        }

        return DB::transaction(function () use (
            $jobOrder,
            $amount,
            $method,
            $reference,
            $notes,
            $paidAt,
        ) {
            $payment = $jobOrder->payments()->create([
                'amount' => $amount,
                'method' => $method,
                'reference' => $reference,
                'notes' => $notes,
                'paid_at' => $paidAt ?? now(),
            ]);

            $jobOrder->updateQuietly([
                'paid_total' => $jobOrder->payments()->sum('amount'),
            ]);

            return $payment;
        });
    }
}
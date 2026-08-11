<?php

namespace App\Actions\Payment;

use App\Models\Payment;
use DomainException;
use Illuminate\Support\Facades\DB;

class RefundPayment
{
    public function handle(
        Payment $payment,
        ?string $reason = null,
    ): Payment {
        if ($payment->amount <= 0) {
            throw new DomainException(
                'This payment cannot be refunded.'
            );
        }

        return DB::transaction(function () use (
            $payment,
            $reason,
        ) {
            $jobOrder = $payment->jobOrder;

            $refund = $jobOrder->payments()->create([
                'amount' => -$payment->amount,
                'method' => $payment->method,
                'reference' => $payment->reference,
                'notes' => 'Refund: ' . ($reason ?? 'No reason provided'),
                'paid_at' => now(),
            ]);

            $jobOrder->updateQuietly([
                'paid_total' => $jobOrder->payments()->sum('amount'),
            ]);

            return $refund;
        });
    }
}
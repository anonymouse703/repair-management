<?php

namespace App\Actions\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use DomainException;

class RefundPayment
{
    public function handle(
        Payment $payment,
        ?string $reason = null,
    ): void {
        if ($payment->amount < 0) {
            throw new DomainException('Payment has already been refunded.');
        }

        DB::transaction(function () use ($payment, $reason) {

            $payment->jobOrder->payments()->create([
                'amount' => -$payment->amount,
                'method' => $payment->method,
                'reference' => $payment->reference,
                'notes' => 'Refund: '.$reason,
                'paid_at' => now(),
            ]);

            $jobOrder = $payment->jobOrder;

            $jobOrder->update([
                'paid_total' => $jobOrder->payments()->sum('amount'),
                'balance_due' => max(
                    0,
                    $jobOrder->estimate_total - $jobOrder->payments()->sum('amount')
                ),
            ]);
        });
    }
}

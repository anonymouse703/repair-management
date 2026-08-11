<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Actions\Payment\RecordPayment;
use App\Filament\Resources\Payments\PaymentResource;
use App\Models\JobOrder;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $jobOrder = JobOrder::findOrFail(
            $data['job_order_id']
        );

        return app(RecordPayment::class)->handle(
            jobOrder: $jobOrder,
            amount: (float) $data['amount'],
            method: $data['method'],
            notes: $data['notes'] ?? null,
            paidAt: ! empty($data['paid_at'])
                ? Carbon::parse($data['paid_at'])
                : null,
        );
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
<?php

namespace App\Actions\JobOrder;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use DomainException;

class ReadyForPickup
{
    public function handle(JobOrder $jobOrder): void
    {
        if ($jobOrder->status !== Status::Testing) {
            throw new DomainException('Job order must complete testing first.');
        }

        $jobOrder->update([
            'status' => Status::ReadyForPickup,
            'completed_at' => now(),
        ]);
    }
}
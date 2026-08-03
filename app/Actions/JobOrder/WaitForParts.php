<?php

namespace App\Actions\JobOrder;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use DomainException;

class WaitForParts
{
    public function handle(JobOrder $jobOrder): void
    {
        if (! in_array($jobOrder->status, [
            Status::Diagnosing,
            Status::WaitingApproval,
        ], true)) {
            throw new DomainException('Job order cannot be moved to waiting for parts.');
        }

        $jobOrder->update([
            'status' => Status::WaitingParts,
        ]);
    }
}

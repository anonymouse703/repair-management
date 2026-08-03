<?php

namespace App\Actions\JobOrder;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use DomainException;

class StartRepair
{
    public function handle(JobOrder $jobOrder): void
    {
        if (! in_array($jobOrder->status, [
            Status::Diagnosing,
            Status::WaitingApproval,
            Status::WaitingParts,
        ], true)) {
            throw new DomainException('Job order cannot start repair.');
        }

        $jobOrder->update([
            'status' => Status::Repairing,
        ]);
    }
}

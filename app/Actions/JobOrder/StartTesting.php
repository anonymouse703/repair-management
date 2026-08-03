<?php

namespace App\Actions\JobOrder;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use DomainException;

class StartTesting
{
    public function handle(JobOrder $jobOrder): void
    {
        if ($jobOrder->status !== Status::Repairing) {
            throw new DomainException('Repair must be completed before testing.');
        }

        $jobOrder->update([
            'status' => Status::Testing,
        ]);
    }
}

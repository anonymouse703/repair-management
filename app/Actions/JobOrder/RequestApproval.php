<?php

namespace App\Actions\JobOrder;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use DomainException;

class RequestApproval
{
    public function handle(JobOrder $jobOrder): void
    {
        if ($jobOrder->status !== Status::Diagnosing) {
            throw new DomainException('Job order must be diagnosing.');
        }

        $jobOrder->update([
            'status' => Status::WaitingApproval,
        ]);
    }
}

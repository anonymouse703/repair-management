<?php

namespace App\Actions\JobOrder;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use DomainException;

class StartDiagnosis
{
    public function handle(JobOrder $jobOrder): void
    {
        if ($jobOrder->status !== Status::Received) {
            throw new DomainException('Only received job orders can start diagnosis.');
        }

        $jobOrder->update([
            'status' => Status::Diagnosing,
        ]);
    }
}

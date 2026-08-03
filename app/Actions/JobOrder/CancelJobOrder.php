<?php

namespace App\Actions\JobOrder;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Illuminate\Support\Facades\DB;
use DomainException;

class CancelJobOrder
{
    public function handle(JobOrder $jobOrder): void
    {
        if (in_array(
            $jobOrder->status,
            [
                Status::Released,
                Status::Cancelled,
            ],
            true
        )) {
            throw new DomainException(
                'This job order cannot be cancelled.'
            );
        }

        DB::transaction(function () use ($jobOrder) {
            $jobOrder->update([
                'status' => Status::Cancelled,
            ]);
        });
    }
}

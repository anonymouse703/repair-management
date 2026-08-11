<?php

namespace App\Actions\JobOrder;

use App\Enums\JobOrder\Status;
use App\Enums\JobOrderService\Status as ServiceStatus;
use App\Models\JobOrder;
use DomainException;
use Illuminate\Support\Facades\DB;

class ApproveJobOrder
{
    public function handle(JobOrder $jobOrder): void
    {
        if ($jobOrder->status !== Status::WaitingApproval) {
            throw new DomainException(
                'Only job orders waiting for approval can be approved.'
            );
        }

        DB::transaction(function () use ($jobOrder) {
            $jobOrder->serviceUsages()
                ->where('status', ServiceStatus::Pending)
                ->update([
                    'status' => ServiceStatus::Approved,
                ]);

            $jobOrder->update([
                'status' => Status::Approved,
            ]);
        });
    }
}
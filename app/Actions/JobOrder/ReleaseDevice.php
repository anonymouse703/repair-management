<?php

namespace App\Actions\JobOrder;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use App\Models\JobOrderReleaseLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReleaseDevice
{
    public function handle(
        JobOrder $jobOrder,
        User $releasedBy,
        ?string $reason = null,
    ): void {

        DB::transaction(function () use (
            $jobOrder,
            $releasedBy,
            $reason,
        ) {

            JobOrderReleaseLog::create([
                'job_order_id' => $jobOrder->id,
                'released_by' => $releasedBy->id,
                'balance_at_release' => $jobOrder->balanceDue(),
                'reason' => $reason,
                'released_at' => now(),
            ]);

            $jobOrder->update([
                'status' => Status::Released,
                'released_at' => now(),
            ]);
        });
    }
}
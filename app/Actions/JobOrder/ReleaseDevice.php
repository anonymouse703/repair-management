<?php

namespace App\Actions\JobOrder;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Illuminate\Support\Facades\DB;
use DomainException;

class ReleaseDevice
{
    public function handle(JobOrder $jobOrder): void
    {
        if ($jobOrder->status !== Status::ReadyForPickup) {
            throw new DomainException(
                'Only job orders ready for pickup can be released.'
            );
        }

        DB::transaction(function () use ($jobOrder) {
            $jobOrder->update([
                'status' => Status::Released,
                'released_at' => now(),
            ]);

            // Optional:
            // $jobOrder->device?->update([
            //     'status' => DeviceStatus::Active,
            // ]);
        });
    }
}

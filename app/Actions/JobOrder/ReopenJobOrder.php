<?php

namespace App\Actions\JobOrder;

use App\Enums\JobOrder\Status;
use App\Models\JobOrder;
use Illuminate\Support\Facades\DB;
use DomainException;

class ReopenJobOrder
{
    public function handle(JobOrder $jobOrder): void
    {
        if ($jobOrder->status !== Status::Cancelled) {
            throw new DomainException(
                'Only cancelled job orders can be reopened.'
            );
        }

        DB::transaction(function () use ($jobOrder) {
            $jobOrder->update([
                'status' => Status::Received,
                'completed_at' => null,
            ]);
        });
    }
}

<?php

namespace App\Actions\Device;

use App\Enums\Device\Status;
use App\Models\Device;
use Illuminate\Support\Facades\DB;
use DomainException;

class ArchiveDevice
{
    public function handle(Device $device): void
    {
        if ($device->status === Status::Archived) {
            throw new DomainException('Device is already archived.');
        }

        if ($device->jobOrders()
            ->whereNotIn('status', ['released','cancelled'])
            ->exists()) {
            throw new DomainException(
                'Device cannot be archived while it has active job orders.'
            );
        }

        DB::transaction(function () use ($device) {
            $device->update([
                'status' => Status::Archived,
            ]);
        });
    }
}

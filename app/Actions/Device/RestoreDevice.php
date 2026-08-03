<?php

namespace App\Actions\Device;

use App\Enums\Device\Status;
use App\Models\Device;
use Illuminate\Support\Facades\DB;
use DomainException;

class RestoreDevice
{
    public function handle(Device $device): void
    {
        if ($device->status !== Status::Archived) {
            throw new DomainException(
                'Only archived devices can be restored.'
            );
        }

        DB::transaction(function () use ($device) {
            $device->update([
                'status' => Status::Active,
            ]);
        });
    }
}

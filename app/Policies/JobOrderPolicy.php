<?php

namespace App\Policies;

use App\Enums\User\Role;
use App\Models\JobOrder;
use App\Models\User;

class JobOrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(Role::SuperAdmin, Role::Manager, Role::Technician, Role::Staff);
    }

    public function view(User $user, JobOrder $jobOrder): bool
    {
        return $this->canAccessRecord($user, $jobOrder);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(Role::SuperAdmin, Role::Manager);
    }

    public function update(User $user, JobOrder $jobOrder): bool
    {
        return $this->canAccessRecord($user, $jobOrder);
    }

    public function delete(User $user, JobOrder $jobOrder): bool
    {
        return $user->hasAnyRole(Role::SuperAdmin, Role::Manager);
    }

    public function deleteAny(User $user): bool
    {
        return $this->delete($user, new JobOrder);
    }

    protected function canAccessRecord(User $user, JobOrder $jobOrder): bool
    {
        if ($user->hasAnyRole(Role::SuperAdmin, Role::Manager)) {
            return true;
        }

        if ($user->hasRole(Role::Technician)) {
            $technician = $user->technicianRecord();

            return filled($technician) && $jobOrder->technician_id === $technician->id;
        }

        return false;
    }
}

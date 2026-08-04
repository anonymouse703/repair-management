<?php

namespace App\Policies;

use App\Enums\User\Role;
use App\Models\Device;
use App\Models\User;

class DevicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(Role::SuperAdmin, Role::Manager, Role::Staff);
    }

    public function view(User $user, Device $device): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(Role::SuperAdmin, Role::Manager, Role::Staff);
    }

    public function update(User $user, Device $device): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, Device $device): bool
    {
        return $user->hasAnyRole(Role::SuperAdmin, Role::Manager);
    }

    public function deleteAny(User $user): bool
    {
        return $this->delete($user, new Device);
    }
}

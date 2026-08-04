<?php

namespace App\Policies;

use App\Enums\User\Role;
use App\Models\Setting;
use App\Models\User;

class SettingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::SuperAdmin);
    }

    public function view(User $user, Setting $setting): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::SuperAdmin);
    }

    public function update(User $user, Setting $setting): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, Setting $setting): bool
    {
        return $this->create($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->delete($user, new Setting);
    }
}

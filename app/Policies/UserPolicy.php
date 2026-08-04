<?php

namespace App\Policies;

use App\Enums\User\Role;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(Role::SuperAdmin, Role::Manager);
    }

    public function view(User $user, User $record): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(Role::SuperAdmin, Role::Manager);
    }

    public function update(User $user, User $record): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, User $record): bool
    {
        return $this->create($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->delete($user, new User);
    }
}

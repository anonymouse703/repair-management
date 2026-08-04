<?php

namespace App\Policies;

use App\Enums\User\Role;
use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(Role::SuperAdmin, Role::Manager, Role::Staff);
    }

    public function view(User $user, Customer $customer): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(Role::SuperAdmin, Role::Manager, Role::Staff);
    }

    public function update(User $user, Customer $customer): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->hasAnyRole(Role::SuperAdmin, Role::Manager);
    }

    public function deleteAny(User $user): bool
    {
        return $this->delete($user, new Customer);
    }
}

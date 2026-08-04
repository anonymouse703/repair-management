<?php

namespace App\Models;

use App\Enums\User\Role;
use App\Models\Contracts\Timezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string|null $username
 * @property string $email
 * @property string|null $phone
 * @property Role $role
 * @property bool $is_active
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'name',
    'username',
    'email',
    'phone',
    'password',
    'role',
    'is_active',
])]
#[Hidden([
    'password',
    'remember_token',
    'two_factor_secret',
    'two_factor_recovery_codes',
])]
class User extends Authenticatable implements PasskeyUser, Timezone
{
    use HasFactory;
    use Notifiable;
    use PasskeyAuthenticatable;
    use TwoFactorAuthenticatable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * User initials.
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1) . Str::substr($initials, -1)
            : $initials;
    }

    /*
    |--------------------------------------------------------------------------
    | Role Helpers
    |--------------------------------------------------------------------------
    */

    public function hasRole(Role $role): bool
    {
        return $this->role === $role;
    }

    public function hasAnyRole(Role ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Role::SuperAdmin);
    }

    public function isManager(): bool
    {
        return $this->hasRole(Role::Manager);
    }

    public function isReceptionist(): bool
    {
        return $this->hasRole(Role::Receptionist);
    }

    public function isTechnician(): bool
    {
        return $this->hasRole(Role::Technician);
    }

    public function isCashier(): bool
    {
        return $this->hasRole(Role::Cashier);
    }

    public function isStaff(): bool
    {
        return $this->hasRole(Role::Staff);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Job Orders assigned to this technician.
     */
    public function jobOrders(): HasMany
    {
        return $this->hasMany(JobOrder::class, 'technician_id');
    }

    /**
     * Inventory usage recorded by this user.
     */
    public function inventoryUsages()
    {
        return $this->hasMany(JobOrderInventory::class, 'used_by');
    }

    /**
     * Inventory movements created by this user.
     */
    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'created_by');
    }

    /**
     * Job order release logs created by this user.
     */
    public function releaseLogs(): HasMany
    {
        return $this->hasMany(JobOrderReleaseLog::class, 'released_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    */

    public function getTimezone(): string
    {
        return 'Asia/Manila';
    }
}
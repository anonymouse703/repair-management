<?php

namespace App\Providers;

use App\Models\JobOrder;
use App\Models\Setting;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, string $ability, $arguments = []) {
            if ($user->isSuperAdmin()) {
                return null;
            }

            $model = is_array($arguments) ? ($arguments[0] ?? null) : $arguments;

            $modelClass = is_string($model)
                ? $model
                : (is_object($model) ? $model::class : null);

            if ($user->isTechnician()) {
                if ($modelClass !== JobOrder::class) {
                    return false;
                }

                return null;
            }

            if ($user->isManager() && $modelClass === Setting::class) {
                return false;
            }

            return null;
        });
    }
}

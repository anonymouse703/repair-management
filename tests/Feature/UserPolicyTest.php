<?php

use App\Enums\User\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

uses(TestCase::class)->in('Feature');

test('technician cannot access user management', function () {
    $technician = User::factory()->create(['role' => Role::Technician]);

    $this->actingAs($technician);

    expect(Gate::forUser($technician)->allows('viewAny', User::class))->toBeFalse();
    expect(Gate::forUser($technician)->allows('create', User::class))->toBeFalse();
});

test('manager can access user management', function () {
    $manager = User::factory()->create(['role' => Role::Manager]);

    $this->actingAs($manager);

    expect(Gate::forUser($manager)->allows('viewAny', User::class))->toBeTrue();
});

test('super admin can access user management', function () {
    $superAdmin = User::factory()->create(['role' => Role::SuperAdmin]);

    $this->actingAs($superAdmin);

    expect(Gate::forUser($superAdmin)->allows('viewAny', User::class))->toBeTrue();
});

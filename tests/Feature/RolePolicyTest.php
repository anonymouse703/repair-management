<?php

use App\Enums\User\Role;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

uses(TestCase::class)->in('Feature');

test('staff can access customers and devices but not settings', function () {
    $user = User::factory()->create(['role' => Role::Staff]);

    $this->actingAs($user);

    expect(Gate::forUser($user)->allows('viewAny', Customer::class))->toBeTrue();
    expect(Gate::forUser($user)->allows('viewAny', Device::class))->toBeTrue();
    expect(Gate::forUser($user)->allows('viewAny', Brand::class))->toBeTrue();
    expect(Gate::forUser($user)->allows('viewAny', DeviceType::class))->toBeTrue();    expect(Gate::forUser($user)->allows('viewAny', Brand::class))->toBeTrue();
    expect(Gate::forUser($user)->allows('viewAny', DeviceType::class))->toBeTrue();    expect(Gate::forUser($user)->allows('viewAny', Setting::class))->toBeFalse();
});

test('manager can access customers and devices but not settings list or settings create', function () {
    $user = User::factory()->create(['role' => Role::Manager]);

    $this->actingAs($user);

    expect(Gate::forUser($user)->allows('viewAny', Customer::class))->toBeTrue();
    expect(Gate::forUser($user)->allows('viewAny', Device::class))->toBeTrue();
    expect(Gate::forUser($user)->allows('viewAny', Setting::class))->toBeFalse();
    expect(Gate::forUser($user)->allows('create', Setting::class))->toBeFalse();
});

test('super admin can access all resources', function () {
    $user = User::factory()->create(['role' => Role::SuperAdmin]);

    $this->actingAs($user);

    expect(Gate::forUser($user)->allows('viewAny', Customer::class))->toBeTrue();
    expect(Gate::forUser($user)->allows('viewAny', Device::class))->toBeTrue();
    expect(Gate::forUser($user)->allows('viewAny', Setting::class))->toBeTrue();
    expect(Gate::forUser($user)->allows('create', Setting::class))->toBeTrue();
});

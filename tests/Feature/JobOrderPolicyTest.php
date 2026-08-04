<?php

use App\Enums\Device\Status as DeviceStatus;
use App\Enums\JobOrder\Status;
use App\Enums\User\Role;
use App\Filament\Resources\JobOrders\JobOrderResource;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\InventoryItem;
use App\Models\JobOrder;
use App\Models\Payment;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

uses(TestCase::class)->in('Feature');

test('technician can only view their assigned job orders', function () {
    $technicianUser = User::factory()->create([
        'role' => Role::Technician,
        'email' => 'tech@example.com',
    ]);

    $technician = Technician::create([
        'name' => 'Assigned Technician',
        'email' => 'tech@example.com',
        'phone' => '09123456789',
        'active' => true,
    ]);

    $customer = Customer::create([
        'name' => 'Test Customer',
        'email' => 'test@example.com',
        'phone' => '09123456789',
        'company' => 'Test Co',
        'address' => '123 Test Street',
        'preferred_contact' => 'email',
        'notes' => 'Test',
        'active' => true,
    ]);

    $device = Device::create([
        'customer_id' => $customer->id,
        'device_type_id' => DeviceType::create([
            'name' => 'Generic Device Type',
            'active' => true,
        ])->id,
        'brand_id' => Brand::create([
            'name' => 'Generic Brand',
            'active' => true,
        ])->id,
        'model' => 'Test Model',
        'serial_number' => 'SN123456',
        'imei' => '012345678901234',
        'status' => DeviceStatus::Active,
        'notes' => 'Test device',
    ]);

    $assignedJobOrder = JobOrder::create([
        'reference_number' => 'JO-TECH-0001',
        'customer_id' => $customer->id,
        'device_id' => $device->id,
        'technician_id' => $technician->id,
        'status' => Status::Repairing,
        'received_at' => now(),
        'estimate_total' => 1000,
        'paid_total' => 0,
    ]);

    $otherTechnician = Technician::create([
        'name' => 'Other Technician',
        'email' => 'other@example.com',
        'phone' => '09129876543',
        'active' => true,
    ]);

    $unassignedJobOrder = JobOrder::create([
        'reference_number' => 'JO-TECH-0002',
        'customer_id' => $customer->id,
        'device_id' => $device->id,
        'technician_id' => $otherTechnician->id,
        'status' => Status::Repairing,
        'received_at' => now(),
        'estimate_total' => 1200,
        'paid_total' => 0,
    ]);

    $this->actingAs($technicianUser);

    expect(Gate::forUser($technicianUser)->allows('viewAny', JobOrder::class))->toBeTrue();
    expect(Gate::forUser($technicianUser)->allows('view', $assignedJobOrder))->toBeTrue();
    expect(Gate::forUser($technicianUser)->allows('view', $unassignedJobOrder))->toBeFalse();

    $recordIds = JobOrderResource::getEloquentQuery()->pluck('id')->all();

    expect($recordIds)->toEqual([$assignedJobOrder->id]);
});

test('technician cannot access brand device type inventory item payment or technician resources', function () {
    $technicianUser = User::factory()->create([
        'role' => Role::Technician,
        'email' => 'tech@example.com',
    ]);

    $this->actingAs($technicianUser);

    expect(Gate::forUser($technicianUser)->allows('viewAny', Brand::class))->toBeFalse();
    expect(Gate::forUser($technicianUser)->allows('viewAny', DeviceType::class))->toBeFalse();
    expect(Gate::forUser($technicianUser)->allows('viewAny', InventoryItem::class))->toBeFalse();
    expect(Gate::forUser($technicianUser)->allows('viewAny', Payment::class))->toBeFalse();
    expect(Gate::forUser($technicianUser)->allows('viewAny', Technician::class))->toBeFalse();
});

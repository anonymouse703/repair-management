<?php

use App\Actions\Inventory\UseInventoryForJobOrder;
use App\Actions\JobOrder\ReleaseDevice;
use App\Actions\Payment\RecordPayment;
use App\Enums\Device\Status as DeviceStatus;
use App\Enums\Inventory\Category;
use App\Enums\JobOrder\Status;
use App\Enums\Payment\Method;
use App\Filament\Resources\JobOrders\JobOrderResource;
use App\Filament\Resources\JobOrders\RelationManagers\InventoryUsagesRelationManager;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\InventoryItem;
use App\Models\JobOrder;
use App\Models\JobOrderInventory;
use App\Models\Payment;
use App\Models\Technician;
use App\Models\User;
use DomainException;

beforeEach(function () {
    // Ensure a valid user exists for release flows.
    $this->user = User::factory()->create();
});

test('job order resource exposes inventory usage relation manager', function () {
    expect(JobOrderResource::getRelations())->toContain(InventoryUsagesRelationManager::class);
});

test('inventory usage deducts stock and records job order inventory usage', function () {
    $customer = Customer::create([
        'name' => 'Alan Turing',
        'email' => 'alan@example.com',
        'phone' => '09123456790',
        'company' => 'Computing Labs',
        'address' => '123 Logic Lane',
        'preferred_contact' => 'email',
        'notes' => 'Test customer',
        'active' => true,
    ]);

    $brand = Brand::create(['name' => 'Test Brand', 'active' => true]);
    $type = DeviceType::create(['name' => 'Smartphone', 'active' => true]);

    $device = Device::create([
        'customer_id' => $customer->id,
        'device_type_id' => $type->id,
        'brand_id' => $brand->id,
        'model' => 'Test Model',
        'serial_number' => 'SN123456',
        'imei' => '012345678901234',
        'status' => DeviceStatus::Active,
        'notes' => 'Test device',
    ]);

    $technician = Technician::create([
        'name' => 'Tech Lead',
        'email' => 'tech@example.com',
        'phone' => '09121234567',
        'active' => true,
    ]);

    $jobOrder = JobOrder::create([
        'reference_number' => 'JO-STOCK-0001',
        'customer_id' => $customer->id,
        'device_id' => $device->id,
        'technician_id' => $technician->id,
        'status' => Status::Repairing,
        'received_at' => now(),
        'estimate_total' => 1200,
        'paid_total' => 0,
    ]);

    $item = InventoryItem::create([
        'name' => 'Battery',
        'sku' => 'BAT-001',
        'category' => Category::RepairPart,
        'unit' => 'pcs',
        'quantity' => 8,
        'reorder_level' => 5,
        'cost' => 300,
        'price' => 500,
        'active' => true,
    ]);

    app(UseInventoryForJobOrder::class)->handle(
        jobOrder: $jobOrder,
        item: $item,
        quantity: 3,
        technician: $technician,
        notes: 'Replaced worn battery',
    );

    $item->refresh();
    $jobOrderInventory = JobOrderInventory::where('job_order_id', $jobOrder->id)
        ->where('inventory_item_id', $item->id)
        ->first();

    expect($item->quantity)->toBe(5);
    expect($jobOrderInventory)->not->toBeNull();
    expect($jobOrderInventory->quantity)->toBe(3);
    expect($jobOrderInventory->cost_at_time)->toBe('300.00');
    expect($item->isLowStock())->toBeTrue();
});

test('record payment updates paid total and balance due correctly', function () {
    $customer = Customer::create([
        'name' => 'Grace Hopper',
        'email' => 'grace@example.com',
        'phone' => '09121234568',
        'company' => 'Navy',
        'address' => '456 Debug Blvd',
        'preferred_contact' => 'phone',
        'notes' => 'Test customer',
        'active' => true,
    ]);

    $brand = Brand::create(['name' => 'Test Brand 2', 'active' => true]);
    $type = DeviceType::create(['name' => 'Tablet', 'active' => true]);

    $device = Device::create([
        'customer_id' => $customer->id,
        'device_type_id' => $type->id,
        'brand_id' => $brand->id,
        'model' => 'Test Tablet',
        'serial_number' => 'SN654321',
        'imei' => '098765432109876',
        'status' => DeviceStatus::Active,
        'notes' => 'Test device',
    ]);

    $jobOrder = JobOrder::create([
        'reference_number' => 'JO-PAY-0001',
        'customer_id' => $customer->id,
        'device_id' => $device->id,
        'status' => Status::ReadyForPickup,
        'received_at' => now(),
        'estimate_total' => 1500,
        'paid_total' => 0,
    ]);

    $payment = app(RecordPayment::class)->handle(
        $jobOrder,
        500,
        Method::Cash->value,
        'CMP-REF-01',
        'Initial partial payment',
    );

    $jobOrder->refresh();

    expect($payment)->toBeInstanceOf(Payment::class);
    expect($jobOrder->paid_total)->toBe('500.00');
    expect($jobOrder->balanceDue())->toBe(1000.0);

    app(RecordPayment::class)->handle(
        $jobOrder,
        1000,
        Method::Cash->value,
        'CMP-REF-02',
        'Final payment',
    );

    $jobOrder->refresh();

    expect($jobOrder->isFullyPaid())->toBeTrue();
    expect($jobOrder->balanceDue())->toBe(0.0);
});

test('release device can only occur when job order is ready for pickup and logs release details', function () {
    $customer = Customer::create([
        'name' => 'Ada Lovelace',
        'email' => 'ada@example.com',
        'phone' => '09121234569',
        'company' => 'Analytics',
        'address' => '789 Algorithm Avenue',
        'preferred_contact' => 'email',
        'notes' => 'Test customer',
        'active' => true,
    ]);

    $brand = Brand::create(['name' => 'Test Brand 3', 'active' => true]);
    $type = DeviceType::create(['name' => 'Laptop', 'active' => true]);

    $device = Device::create([
        'customer_id' => $customer->id,
        'device_type_id' => $type->id,
        'brand_id' => $brand->id,
        'model' => 'Test Laptop',
        'serial_number' => 'SN987654',
        'imei' => '011223344556677',
        'status' => DeviceStatus::Active,
        'notes' => 'Test device',
    ]);

    $jobOrder = JobOrder::create([
        'reference_number' => 'JO-REL-0001',
        'customer_id' => $customer->id,
        'device_id' => $device->id,
        'status' => Status::Testing,
        'received_at' => now(),
        'estimate_total' => 1200,
        'paid_total' => 1200,
    ]);

    $this->expectException(DomainException::class);

    app(ReleaseDevice::class)->handle(
        $jobOrder,
        $this->user,
        'Attempt early release',
    );

    $jobOrder->status = Status::ReadyForPickup;
    $jobOrder->save();

    app(ReleaseDevice::class)->handle(
        $jobOrder,
        $this->user,
        'Customer arrived to pick up device',
    );

    $jobOrder->refresh();

    expect($jobOrder->status)->toBe(Status::Released);
    expect($jobOrder->released_at)->not->toBeNull();
    expect($jobOrder->releaseLogs()->count())->toBe(1);
    expect($jobOrder->releaseLogs()->first()->reason)->toBe('Customer arrived to pick up device');
});

<?php

use App\Models\Customer;
use App\Models\Device;
use App\Models\JobOrder;
use App\Models\Service;

test('homepage search returns job order by client name', function () {
    $customer = Customer::create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '09123456789',
        'company' => 'Test Co',
        'address' => '123 Test Street',
        'preferred_contact' => 'phone',
        'notes' => 'Test customer',
        'active' => true,
    ]);

    $device = Device::create([
        'customer_id' => $customer->id,
        'type' => 'Phone',
        'brand' => 'Apple',
        'model' => 'iPhone 14',
        'serial_number' => 'SN123456',
        'imei' => '011234567890123',
        'status' => 'received',
        'notes' => 'Test device',
    ]);

    $jobOrder = JobOrder::create([
        'reference_number' => 'JO-TEST-0001',
        'customer_id' => $customer->id,
        'device_id' => $device->id,
        'status' => 'pending',
        'received_at' => now(),
    ]);

    $service = Service::create([
        'name' => 'Screen repair',
        'description' => 'Glass replacement',
        'price' => 1000,
        'cost' => 500,
        'category' => 'repair',
        'active' => true,
    ]);

    $jobOrder->services()->attach($service->id, ['quantity' => 1, 'price' => 1000]);

    $response = $this->get('/?query=Jane&search_by=name');

    $response->assertOk();
    $response->assertSeeText('JO-TEST-0001');
    $response->assertSeeText('Jane Doe');
    $response->assertSeeText('Screen repair');
    $response->assertSeeText('Pending');
});

test('homepage search returns job order by reference number', function () {
    $customer = Customer::create([
        'name' => 'John Smith',
        'email' => 'john@example.com',
        'phone' => '09123456780',
        'company' => 'Sample Co',
        'address' => '456 Sample Avenue',
        'preferred_contact' => 'email',
        'notes' => 'Another customer',
        'active' => true,
    ]);

    $device = Device::create([
        'customer_id' => $customer->id,
        'type' => 'Tablet',
        'brand' => 'Samsung',
        'model' => 'Galaxy Tab',
        'serial_number' => 'SN654321',
        'imei' => '009876543210987',
        'status' => 'received',
        'notes' => 'Sample device',
    ]);

    $jobOrder = JobOrder::create([
        'reference_number' => 'JO-REF-1234',
        'customer_id' => $customer->id,
        'device_id' => $device->id,
        'status' => 'repairing',
        'received_at' => now(),
    ]);

    $service = Service::create([
        'name' => 'Battery replacement',
        'description' => 'Replace tablet battery',
        'price' => 1400,
        'cost' => 800,
        'category' => 'repair',
        'active' => true,
    ]);

    $jobOrder->services()->attach($service->id, ['quantity' => 1, 'price' => 1400]);

    $response = $this->get('/?query=JO-REF-1234&search_by=reference');

    $response->assertOk();
    $response->assertSeeText('JO-REF-1234');
    $response->assertSeeText('John Smith');
    $response->assertSeeText('Battery replacement');
    $response->assertSeeText('Repairing');
});

<?php

namespace Database\Seeders;

use App\Models\DeviceType;
use Illuminate\Database\Seeder;

class DeviceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $devicetypes = [
            [
                'name' => 'Mobile Phone',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Tablet',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Smart Watch',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Laptop',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Desktop Computer',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'All-in-One PC',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Mini PC',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Server',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Monitor',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Television',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Projector',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Printer',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Scanner',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Copier',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Speaker',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Amplifier',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Sound System',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Home Theater',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Microphone',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Router',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Modem',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Access Point',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Network Switch',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'CCTV',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Game Console',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'VR Headset',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'External Hard Drive',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'NAS',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Air Conditioner',
                'description' => null,
                'active' => true,
            ],
            [
                'name' => 'Other',
                'description' => null,
                'active' => true,
            ],
        ];

        foreach ($devicetypes as $item) {
            DeviceType::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
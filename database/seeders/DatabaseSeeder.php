<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            DeviceTypeSeeder::class,
            ServiceSeeder::class,
            InventoryItemSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Enums\Inventory\Category;
use App\Enums\Inventory\Unit;
use App\Models\InventoryItem;
use Illuminate\Database\Seeder;

class InventoryItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [

            /*
            |--------------------------------------------------------------------------
            | REPAIR PARTS
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'iPhone Charging Port',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 10,
                'reorder_level' => 3,
                'cost' => 350.00,
                'price' => 750.00,
                'location' => 'Parts Shelf A1',
                'active' => true,
                'notes' => 'Common iPhone charging port replacement part.',
            ],

            [
                'name' => 'Android Charging Port Type-C',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 20,
                'reorder_level' => 5,
                'cost' => 120.00,
                'price' => 350.00,
                'location' => 'Parts Shelf A1',
                'active' => true,
                'notes' => 'Universal Type-C charging port replacement.',
            ],

            [
                'name' => 'Micro USB Charging Port',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 15,
                'reorder_level' => 5,
                'cost' => 80.00,
                'price' => 250.00,
                'location' => 'Parts Shelf A1',
                'active' => true,
                'notes' => 'Micro USB charging port.',
            ],

            [
                'name' => 'iPhone LCD Display',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 5,
                'reorder_level' => 2,
                'cost' => 1800.00,
                'price' => 3500.00,
                'location' => 'Parts Shelf B1',
                'active' => true,
                'notes' => 'LCD replacement. Model-specific.',
            ],

            [
                'name' => 'Android LCD Display',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 8,
                'reorder_level' => 3,
                'cost' => 900.00,
                'price' => 1800.00,
                'location' => 'Parts Shelf B1',
                'active' => true,
                'notes' => 'Android LCD replacement. Model-specific.',
            ],

            [
                'name' => 'Laptop LCD 15.6"',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 3,
                'reorder_level' => 1,
                'cost' => 2800.00,
                'price' => 4500.00,
                'location' => 'Parts Shelf B2',
                'active' => true,
                'notes' => '15.6 inch laptop LCD panel.',
            ],

            [
                'name' => 'Laptop Keyboard',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 5,
                'reorder_level' => 2,
                'cost' => 800.00,
                'price' => 1500.00,
                'location' => 'Parts Shelf B2',
                'active' => true,
                'notes' => 'Laptop keyboard. Model-specific.',
            ],

            [
                'name' => 'Laptop DC Jack',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 15,
                'reorder_level' => 5,
                'cost' => 100.00,
                'price' => 300.00,
                'location' => 'Parts Shelf A2',
                'active' => true,
                'notes' => 'Replacement DC power jack.',
            ],

            [
                'name' => 'Laptop Cooling Fan',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 5,
                'reorder_level' => 2,
                'cost' => 450.00,
                'price' => 900.00,
                'location' => 'Parts Shelf B3',
                'active' => true,
                'notes' => 'Model-specific cooling fan.',
            ],

            [
                'name' => 'Laptop Battery',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 5,
                'reorder_level' => 2,
                'cost' => 1200.00,
                'price' => 2200.00,
                'location' => 'Parts Shelf B3',
                'active' => true,
                'notes' => 'Model-specific replacement battery.',
            ],

            [
                'name' => 'Speaker Module',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 10,
                'reorder_level' => 3,
                'cost' => 150.00,
                'price' => 400.00,
                'location' => 'Parts Shelf A3',
                'active' => true,
                'notes' => 'Device speaker replacement.',
            ],

            [
                'name' => 'Camera Module',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 5,
                'reorder_level' => 2,
                'cost' => 500.00,
                'price' => 1000.00,
                'location' => 'Parts Shelf A3',
                'active' => true,
                'notes' => 'Camera module. Model-specific.',
            ],

            [
                'name' => 'Replacement Battery Connector',
                'category' => Category::RepairPart,
                'unit' => Unit::Piece,
                'quantity' => 20,
                'reorder_level' => 5,
                'cost' => 50.00,
                'price' => 150.00,
                'location' => 'Small Parts Drawer 1',
                'active' => true,
                'notes' => 'Small replacement connector.',
            ],

            /*
            |--------------------------------------------------------------------------
            | CONSUMABLES
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'Solder Wire',
                'category' => Category::Consumable,
                'unit' => Unit::Roll,
                'quantity' => 10,
                'reorder_level' => 3,
                'cost' => 250.00,
                'price' => 450.00,
                'location' => 'Consumables Shelf C1',
                'active' => true,
                'notes' => 'Solder wire roll.',
            ],

            [
                'name' => 'Flux Paste',
                'category' => Category::Consumable,
                'unit' => Unit::Piece,
                'quantity' => 10,
                'reorder_level' => 3,
                'cost' => 120.00,
                'price' => 250.00,
                'location' => 'Consumables Shelf C1',
                'active' => true,
                'notes' => 'Soldering flux paste.',
            ],

            [
                'name' => 'Isopropyl Alcohol',
                'category' => Category::Consumable,
                'unit' => Unit::Liter,
                'quantity' => 5,
                'reorder_level' => 2,
                'cost' => 350.00,
                'price' => 600.00,
                'location' => 'Consumables Shelf C2',
                'active' => true,
                'notes' => 'For board and component cleaning.',
            ],

            [
                'name' => 'Kapton Tape',
                'category' => Category::Consumable,
                'unit' => Unit::Roll,
                'quantity' => 10,
                'reorder_level' => 3,
                'cost' => 150.00,
                'price' => 300.00,
                'location' => 'Consumables Shelf C2',
                'active' => true,
                'notes' => 'Heat-resistant electrical tape.',
            ],

            [
                'name' => 'Double Sided Adhesive Tape',
                'category' => Category::Consumable,
                'unit' => Unit::Roll,
                'quantity' => 10,
                'reorder_level' => 3,
                'cost' => 100.00,
                'price' => 250.00,
                'location' => 'Consumables Shelf C2',
                'active' => true,
                'notes' => 'Used for LCD and battery installation.',
            ],

            [
                'name' => 'Soldering Wick',
                'category' => Category::Consumable,
                'unit' => Unit::Roll,
                'quantity' => 8,
                'reorder_level' => 2,
                'cost' => 180.00,
                'price' => 350.00,
                'location' => 'Consumables Shelf C1',
                'active' => true,
                'notes' => 'Desoldering braid.',
            ],

            [
                'name' => 'Thermal Paste',
                'category' => Category::Consumable,
                'unit' => Unit::Piece,
                'quantity' => 10,
                'reorder_level' => 3,
                'cost' => 150.00,
                'price' => 300.00,
                'location' => 'Consumables Shelf C3',
                'active' => true,
                'notes' => 'For CPU and GPU thermal maintenance.',
            ],

            [
                'name' => 'Cleaning Wipes',
                'category' => Category::Consumable,
                'unit' => Unit::Pack,
                'quantity' => 10,
                'reorder_level' => 3,
                'cost' => 100.00,
                'price' => 200.00,
                'location' => 'Consumables Shelf C3',
                'active' => true,
                'notes' => 'Cleaning wipes for repair work.',
            ],

            /*
            |--------------------------------------------------------------------------
            | EQUIPMENT
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'Digital Multimeter',
                'category' => Category::Equipment,
                'unit' => Unit::Piece,
                'quantity' => 3,
                'reorder_level' => 1,
                'cost' => 1200.00,
                'price' => 0,
                'location' => 'Workshop Bench',
                'active' => true,
                'notes' => 'Digital multimeter for electrical testing.',
            ],

            [
                'name' => 'Hot Air Rework Station',
                'category' => Category::Equipment,
                'unit' => Unit::Piece,
                'quantity' => 2,
                'reorder_level' => 1,
                'cost' => 4500.00,
                'price' => 0,
                'location' => 'Workshop Bench',
                'active' => true,
                'notes' => 'Hot air station for board repair.',
            ],

            [
                'name' => 'Soldering Station',
                'category' => Category::Equipment,
                'unit' => Unit::Piece,
                'quantity' => 3,
                'reorder_level' => 1,
                'cost' => 2500.00,
                'price' => 0,
                'location' => 'Workshop Bench',
                'active' => true,
                'notes' => 'Temperature-controlled soldering station.',
            ],

            [
                'name' => 'DC Power Supply',
                'category' => Category::Equipment,
                'unit' => Unit::Piece,
                'quantity' => 2,
                'reorder_level' => 1,
                'cost' => 5000.00,
                'price' => 0,
                'location' => 'Workshop Bench',
                'active' => true,
                'notes' => 'Adjustable DC power supply.',
            ],

            [
                'name' => 'Digital Microscope',
                'category' => Category::Equipment,
                'unit' => Unit::Piece,
                'quantity' => 1,
                'reorder_level' => 0,
                'cost' => 8000.00,
                'price' => 0,
                'location' => 'Workshop Bench',
                'active' => true,
                'notes' => 'Digital microscope for board inspection.',
            ],

            [
                'name' => 'Laptop Repair Computer',
                'category' => Category::Equipment,
                'unit' => Unit::Piece,
                'quantity' => 2,
                'reorder_level' => 1,
                'cost' => 30000.00,
                'price' => 0,
                'location' => 'Workshop Office',
                'active' => true,
                'notes' => 'Computer used for diagnostics and firmware tools.',
            ],

            /*
            |--------------------------------------------------------------------------
            | ACCESSORIES
            |--------------------------------------------------------------------------
            */

            [
                'name' => 'USB Type-C Cable',
                'category' => Category::Accessory,
                'unit' => Unit::Piece,
                'quantity' => 20,
                'reorder_level' => 5,
                'cost' => 100.00,
                'price' => 250.00,
                'location' => 'Accessory Shelf D1',
                'active' => true,
                'notes' => 'USB Type-C cable.',
            ],

            [
                'name' => 'Micro USB Cable',
                'category' => Category::Accessory,
                'unit' => Unit::Piece,
                'quantity' => 15,
                'reorder_level' => 5,
                'cost' => 80.00,
                'price' => 200.00,
                'location' => 'Accessory Shelf D1',
                'active' => true,
                'notes' => 'Micro USB cable.',
            ],

            [
                'name' => 'USB Power Adapter',
                'category' => Category::Accessory,
                'unit' => Unit::Piece,
                'quantity' => 10,
                'reorder_level' => 3,
                'cost' => 250.00,
                'price' => 500.00,
                'location' => 'Accessory Shelf D2',
                'active' => true,
                'notes' => 'USB power adapter.',
            ],

            [
                'name' => 'HDMI Cable',
                'category' => Category::Accessory,
                'unit' => Unit::Piece,
                'quantity' => 10,
                'reorder_level' => 3,
                'cost' => 150.00,
                'price' => 300.00,
                'location' => 'Accessory Shelf D2',
                'active' => true,
                'notes' => 'HDMI cable.',
            ],
        ];

        foreach ($items as $item) {
            InventoryItem::updateOrCreate(
                [
                    'name' => $item['name'],
                ],
                $item
            );
        }
    }
}
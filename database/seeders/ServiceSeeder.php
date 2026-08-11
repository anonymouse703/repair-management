<?php

namespace Database\Seeders;

use App\Enums\Service\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // ============================================================
            // DIAGNOSTIC
            // ============================================================
            [
                'name' => 'General Check-up',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Device Diagnosis',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Hardware Inspection',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Software Diagnosis',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Power Issue Diagnosis',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Boot Failure Diagnosis',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],

            // ============================================================
            // SOFTWARE
            // ============================================================
            [
                'name' => 'Windows Reformat',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Windows Restore',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Operating System Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Software Update',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Driver Installation',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Application Installation',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Microsoft Office Installation',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Adobe Installation',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Antivirus Installation',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Virus Removal',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Malware Removal',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Password Removal',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'BIOS Update',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],

            // ============================================================
            // INSTALLATION
            // ============================================================
            [
                'name' => 'Windows Installation',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Linux Installation',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'macOS Installation',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Printer Installation',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Scanner Installation',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Driver Setup',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],

            // ============================================================
            // RECOVERY
            // ============================================================
            [
                'name' => 'Data Recovery',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'File Recovery',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Data Backup',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Data Migration',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'SSD Clone',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],

            // ============================================================
            // HARDWARE
            // ============================================================
            [
                'name' => 'LCD Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'OLED Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Touchscreen Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Screen Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Battery Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Charging Port Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Motherboard Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Power Supply Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'RAM Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'SSD Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Hard Drive Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Keyboard Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Trackpad Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Laptop Hinge Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Cooling Fan Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Thermal Paste Reapplication',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Webcam Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Microphone Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Speaker Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Camera Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Fingerprint Sensor Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Face ID Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'SIM Tray Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Back Glass Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'GPU Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'CPU Socket Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'TV Backlight Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'TV Main Board Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'TV Power Board Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'TV Panel Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'TV HDMI Port Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Amplifier Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Audio Board Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Bluetooth Speaker Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Speaker Recone',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Subwoofer Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Print Head Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Roller Replacement',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Paper Feed Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],

            // ============================================================
            // CLEANING
            // ============================================================
            [
                'name' => 'Internal Cleaning',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Dust Cleaning',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Water Damage Cleaning',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Ultrasonic Cleaning',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],

            // ============================================================
            // MAINTENANCE
            // ============================================================
            [
                'name' => 'Preventive Maintenance',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Printer Maintenance',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'TV Maintenance',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Speaker Maintenance',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Laptop Maintenance',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Desktop Maintenance',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],

            // ============================================================
            // UPGRADE
            // ============================================================
            [
                'name' => 'RAM Upgrade',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'SSD Upgrade',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'CPU Upgrade',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'GPU Upgrade',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Storage Upgrade',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],

            // ============================================================
            // NETWORK
            // ============================================================
            [
                'name' => 'Network Configuration',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'WiFi Setup',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Router Configuration',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Router Firmware Update',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Network Troubleshooting',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'LAN Cable Crimping',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],

            // ============================================================
            // OTHER
            // ============================================================
            [
                'name' => 'Home Service',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Pull-out Service',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Rush Service',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
            [
                'name' => 'Other Repair',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],


            //Service Fee
            [
                'name' => 'Service Fee',
                'description' => null,
                'price' => 1.00,
                'active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                [
                    'name' => $service['name'],
                ],
                $service
            );
        }
    }
}
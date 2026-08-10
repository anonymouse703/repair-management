<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [

            /*
            |--------------------------------------------------------------------------
            | Shop Information
            |--------------------------------------------------------------------------
            */

            [
                'key' => 'shop_name',
                'value' => 'Your Repair Shop',
                'scope' => 'system',
                'label' => 'Shop Name',
                'description' => 'Official name of the repair shop.',
                'type' => 'text',
                'options' => null,
                'is_readonly' => false,
            ],

            [
                'key' => 'contact_number_1',
                'value' => '09123456789',
                'scope' => 'system',
                'label' => 'Primary Contact Number',
                'description' => 'Primary contact number displayed on receipts and documents.',
                'type' => 'text',
                'options' => null,
                'is_readonly' => false,
            ],

            [
                'key' => 'contact_number_2',
                'value' => '',
                'scope' => 'system',
                'label' => 'Secondary Contact Number',
                'description' => 'Optional secondary contact number.',
                'type' => 'text',
                'options' => null,
                'is_readonly' => false,
            ],

            [
                'key' => 'email',
                'value' => 'shop@example.com',
                'scope' => 'system',
                'label' => 'Shop Email',
                'description' => 'Official email address displayed on receipts.',
                'type' => 'text',
                'options' => null,
                'is_readonly' => false,
            ],

            [
                'key' => 'address',
                'value' => 'Your Shop Address',
                'scope' => 'system',
                'label' => 'Shop Address',
                'description' => 'Complete business address displayed on receipts and documents.',
                'type' => 'text',
                'options' => null,
                'is_readonly' => false,
            ],

            /*
            |--------------------------------------------------------------------------
            | Business / Tax Information
            |--------------------------------------------------------------------------
            */

            [
                'key' => 'tin',
                'value' => '',
                'scope' => 'system',
                'label' => 'TIN',
                'description' => 'Tax Identification Number of the business.',
                'type' => 'text',
                'options' => null,
                'is_readonly' => false,
            ],

            [
                'key' => 'business_registration_name',
                'value' => 'Your Registered Business Name',
                'scope' => 'system',
                'label' => 'Registered Business Name',
                'description' => 'Business name registered with the appropriate government agency.',
                'type' => 'text',
                'options' => null,
                'is_readonly' => false,
            ],

            [
                'key' => 'business_registration_number',
                'value' => '',
                'scope' => 'system',
                'label' => 'Business Registration Number',
                'description' => 'Business registration number such as DTI or SEC registration number.',
                'type' => 'text',
                'options' => null,
                'is_readonly' => false,
            ],

            /*
            |--------------------------------------------------------------------------
            | Receipt Information
            |--------------------------------------------------------------------------
            */

            [
                'key' => 'receipt_footer',
                'value' => 'Thank you for trusting us with your device.',
                'scope' => 'system',
                'label' => 'Receipt Footer',
                'description' => 'Message displayed at the bottom of the Job Order receipt.',
                'type' => 'text',
                'options' => null,
                'is_readonly' => false,
            ],

            [
                'key' => 'receipt_terms',
                'value' => 'Please present this Job Order when claiming your device.',
                'scope' => 'system',
                'label' => 'Receipt Terms',
                'description' => 'Terms or instructions displayed on the Job Order receipt.',
                'type' => 'text',
                'options' => null,
                'is_readonly' => false,
            ],

            [
                'key' => 'receipt_show_tin',
                'value' => '1',
                'scope' => 'system',
                'label' => 'Show TIN on Receipt',
                'description' => 'Whether the TIN should be displayed on the Job Order receipt.',
                'type' => 'boolean',
                'options' => null,
                'is_readonly' => false,
            ],

            [
                'key' => 'receipt_show_email',
                'value' => '1',
                'scope' => 'system',
                'label' => 'Show Email on Receipt',
                'description' => 'Whether the shop email should be displayed on the Job Order receipt.',
                'type' => 'boolean',
                'options' => null,
                'is_readonly' => false,
            ],

            /*
            |--------------------------------------------------------------------------
            | System Settings
            |--------------------------------------------------------------------------
            */

            [
                'key' => 'currency',
                'value' => 'PHP',
                'scope' => 'system',
                'label' => 'Currency',
                'description' => 'Currency used throughout the application.',
                'type' => 'select',
                'options' => json_encode([
                    'PHP' => 'Philippine Peso',
                    'USD' => 'US Dollar',
                ]),
                'is_readonly' => false,
            ],

            [
                'key' => 'timezone',
                'value' => 'Asia/Manila',
                'scope' => 'system',
                'label' => 'Timezone',
                'description' => 'Default timezone used by the application.',
                'type' => 'select',
                'options' => json_encode([
                    'Asia/Manila' => 'Asia/Manila',
                    'UTC' => 'UTC',
                ]),
                'is_readonly' => false,
            ],

        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
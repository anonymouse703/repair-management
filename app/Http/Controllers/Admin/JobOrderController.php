<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOrder;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;

class JobOrderController extends Controller
{
    public function receipt(JobOrder $jobOrder)
    {
        $jobOrder->load([
            'customer',
            'device.brand',
            'technician',
            'services',
            'inventoryUsages.inventoryItem',
            'payments',
        ]);

       $settings = Setting::query()
            ->whereIn('key', [
                'shop_name',
                'business_registration_name',
                'address',
                'contact_number_1',
                'contact_number_2',
                'email',
                'tin',
                'business_registration_number',
                'receipt_show_email',
                'receipt_show_tin',
                'receipt_terms',
                'receipt_footer',
            ])
            ->pluck('value', 'key');

        return Pdf::loadView(
            'job-orders.receipt',
            [
                'jobOrder' => $jobOrder,
                'settings' => $settings,
            ]
        )->stream(
            $jobOrder->reference_number . '.pdf'
        );
    }
}
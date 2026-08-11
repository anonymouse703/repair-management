<?php

namespace App\Http\Controllers\Admin;

use App\Cache\JobOrder\JobOrderByReference;
use App\Cache\JobOrder\JobOrdersByCustomerName;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\JobOrderResource;
use App\Models\JobOrder;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{
    public function search(Request $request)
    {
        $type = $request->string('type')->toString();
        $query = $request->string('query')->trim()->toString();

        if (blank($query)) {
            return view('welcome', [
                'type' => null,
                'query' => null,
                'jobOrder' => null,
                'jobOrders' => collect(),
                'error' => 'Search query is required.',
            ]);
        }

        if ($type === 'reference') {
            $jobOrder = JobOrderByReference::get($query);

            return view('welcome', [
                'type' => 'reference',
                'query' => $query,
                'jobOrder' => $jobOrder,
                'jobOrders' => collect(),
                'error' => $jobOrder ? null : 'Job Order not found.',
            ]);
        }

        if ($type === 'customer') {
            $jobOrders = JobOrdersByCustomerName::get($query);

            return view('welcome', [
                'type' => 'customer',
                'query' => $query,
                'jobOrder' => null,
                'jobOrders' => $jobOrders,
                'error' => null,
            ]);
        }

        return view('welcome', [
            'type' => $type,
            'query' => $query,
            'jobOrder' => null,
            'jobOrders' => collect(),
            'error' => 'Invalid search type.',
        ]);
    }
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
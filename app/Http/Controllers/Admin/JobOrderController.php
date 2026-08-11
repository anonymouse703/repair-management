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
use Illuminate\Http\JsonResponse;

class JobOrderController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $type = $request->string('type')->toString();
        $query = $request->string('query')->trim()->toString();

        if (blank($query)) {
            return response()->json([
                'message' => $type === 'customer'
                    ? 'Please enter a customer name.'
                    : 'Please enter a Job Order reference number.',
            ], 422);
        }

        if ($type === 'reference') {
            $jobOrder = JobOrderByReference::get($query);

            if (! $jobOrder) {
                return response()->json([
                    'message' => 'Job Order not found.',
                ], 404);
            }

            return response()->json([
                'data' => new JobOrderResource($jobOrder),
            ]);
        }

        if ($type === 'customer') {
            $jobOrders = JobOrdersByCustomerName::get($query);

            return response()->json([
                'data' => JobOrderResource::collection($jobOrders),
            ]);
        }

        return response()->json([
            'message' => 'Invalid search type.',
        ], 422);
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
            ->get()
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
<?php

use App\Enums\JobOrder\Status;
use App\Http\Controllers\Admin\JobOrderController;
use App\Models\JobOrder;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $activeStatuses = [
        Status::Received->value,
        Status::Diagnosing->value,
        Status::WaitingApproval->value,
        Status::WaitingParts->value,
        Status::Repairing->value,
        Status::Testing->value,
        Status::ReadyForPickup->value,
    ];

    $activeRepairCounts = JobOrder::query()
        ->whereIn('job_orders.status', $activeStatuses)
        ->join(
            'devices',
            'devices.id',
            '=',
            'job_orders.device_id'
        )
        ->join(
            'device_types',
            'device_types.id',
            '=',
            'devices.device_type_id'
        )
        ->selectRaw('device_types.name, COUNT(*) as total')
        ->groupBy(
            'device_types.id',
            'device_types.name'
        )
        ->pluck('total', 'name');

    return view('welcome', [
        'activeMobileRepairs' => $activeRepairCounts->get('Mobile', 0),
        'activeLaptopRepairs' => $activeRepairCounts->get('Laptop', 0),
        'activeTvRepairs' => $activeRepairCounts->get('TV', 0),
    ]);

})->name('home');

Route::middleware(['auth'])->group(function () {
    
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get(
        '/job-orders/search',
        [JobOrderController::class, 'search']
    )->name('job-orders.search');

    Route::get(
        '/job-orders/{jobOrder}/receipt',
        [JobOrderController::class, 'receipt']
    )->name('job-orders.receipt');
});

require __DIR__.'/settings.php';
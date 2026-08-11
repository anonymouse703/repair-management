<?php

use App\Enums\JobOrder\Status;
use App\Http\Controllers\Admin\JobOrderController;
use App\Models\JobOrder;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $openStatuses = [
        Status::Received->value,
        Status::Diagnosing->value,
        Status::WaitingApproval->value,
        Status::WaitingParts->value,
        Status::Repairing->value,
        Status::Testing->value,
        Status::ReadyForPickup->value,
        Status::Approved->value,
    ];

    $totalJobOrders = JobOrder::query()->count();

    $openJobOrders = JobOrder::query()
        ->whereIn('status', $openStatuses)
        ->count();

    $readyForPickup = JobOrder::query()
        ->where('status', Status::ReadyForPickup->value)
        ->count();

    $receivedToday = JobOrder::query()
        ->whereDate('received_at', today())
        ->count();

    return view('welcome', [
        'totalJobOrders' => $totalJobOrders,
        'openJobOrders' => $openJobOrders,
        'readyForPickup' => $readyForPickup,
        'receivedToday' => $receivedToday,
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
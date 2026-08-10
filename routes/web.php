<?php

use App\Http\Controllers\Admin\JobOrderController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get(
        '/job-orders/{jobOrder}/receipt',
        [JobOrderController::class, 'receipt']
    )->name('job-orders.receipt');
});

require __DIR__.'/settings.php';

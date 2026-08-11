<?php

namespace App\Observers;

use App\Models\JobOrder;

class JobOrderObserver
{
    /**
     * Handle the JobOrder "created" event.
     */
    public function created(JobOrder $jobOrder): void
    {
        $jobOrder->clearCache();
    }

    /**
     * Handle the JobOrder "updated" event.
     */
    public function updated(JobOrder $jobOrder): void
    {
        $jobOrder->clearCache();
    }

    /**
     * Handle the JobOrder "deleted" event.
     */
    public function deleted(JobOrder $jobOrder): void
    {
        $jobOrder->clearCache();
    }

    /**
     * Handle the JobOrder "restored" event.
     */
    public function restored(JobOrder $jobOrder): void
    {
        $jobOrder->clearCache();
    }

    /**
     * Handle the JobOrder "force deleted" event.
     */
    public function forceDeleted(JobOrder $jobOrder): void
    {
        $jobOrder->clearCache();
    }
}

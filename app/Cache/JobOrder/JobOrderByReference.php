<?php

namespace App\Cache\JobOrder;

use App\Cache\CacheBase;
use App\Cache\Traits\WithHelpers;
use App\Repositories\Contracts\JobOrderRepositoryInterface;

class JobOrderByReference extends CacheBase
{
    use WithHelpers;

    public function __construct(
        protected string $referenceNumber
    ) {
        parent::__construct(
            'job-orders.reference.' . $referenceNumber,
            now()->addMinutes(30)
        );
    }

    protected function cacheMiss()
    {
        return app(JobOrderRepositoryInterface::class)
            ->with([
                'customer',
                'device',
                'technician',
                'serviceUsages.service',
            ])
            ->filterByReferenceNumber($this->referenceNumber)
            ->first();
    }

    protected function errorModelName(): string
    {
        return 'Job Order';
    }

    protected function errorModelId(): mixed
    {
        return $this->referenceNumber;
    }
}
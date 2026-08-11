<?php

namespace App\Cache\JobOrder;

use App\Cache\CacheBase;
use App\Cache\Traits\WithHelpers;
use App\Repositories\Contracts\JobOrderRepositoryInterface;

class JobOrdersByCustomerName extends CacheBase
{
    use WithHelpers;

    public function __construct(
        protected string $customerName
    ) {
        parent::__construct(
            'job-orders.customer.' . md5(strtolower($customerName)),
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
            ->filterByCustomerName($this->customerName)
            ->get();
    }

    protected function errorModelName(): string
    {
        return 'Job Orders';
    }

    protected function errorModelId(): mixed
    {
        return $this->customerName;
    }
}
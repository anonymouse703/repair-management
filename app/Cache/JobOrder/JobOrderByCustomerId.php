<?php

namespace App\Cache\JobOrder;

use App\Cache\CacheBase;
use App\Cache\Traits\WithHelpers;
use App\Repositories\Contracts\JobOrderRepositoryInterface;

class JobOrdersByCustomerId extends CacheBase
{
    use WithHelpers;

    public function __construct(
        protected int $id
    ) {
        parent::__construct(
            'job-orders.customer.' . $id,
            now()->addMinutes(15)
        );
    }

    protected function cacheMiss()
    {
        return app(JobOrderRepositoryInterface::class)->with(['customer','device','technician','serviceUsages.service'])->find($this->id);
    }

    protected function errorModelName(): string
    {
        return 'Job Orders';
    }

    protected function errorModelId(): mixed
    {
        return $this->id;
    }
}
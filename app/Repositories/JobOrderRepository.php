<?php

namespace App\Repositories;

use App\Models\JobOrder;
use App\Repositories\Contracts\JobOrderRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class JobOrderRepository extends BaseRepository implements JobOrderRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(app(JobOrder::class));
    }

    public function filterByReferenceNumber(string $referenceNumber): static
    {
        return $this->filter(static fn(Builder $builder) => $builder->where('reference_number', $referenceNumber));
    }

    public function filterByCustomerName(string $customerName): static
    {
        return $this->filter(
            static fn (Builder $builder) => $builder->whereHas(
                'customer',
                fn (Builder $query) => $query->where(
                    'name',
                    'like',
                    '%' . $customerName . '%'
                )
            )
        );
    }
}

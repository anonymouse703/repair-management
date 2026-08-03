<?php

namespace App\Cache\Department;

use App\Cache\CacheBase;
use App\Cache\Traits\WithHelpers;
use App\Repositories\Contracts\DepartmentRepositoryInterface;

class RouteSlipDepartments extends CacheBase
{
    use WithHelpers;

    public function __construct()
    {
        parent::__construct(
            'departments.unique.list',
            now()->addDays(30)
        );
    }

    protected function cacheMiss()
    {
        return app(DepartmentRepositoryInterface::class)
            ->getUniqueDepartments();
    }

    protected function errorModelName(): string
    {
        return 'Departments';
    }

    protected function errorModelId(): int
    {
        return 0;
    }
}
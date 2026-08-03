<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\Repositories\Contracts\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function create(array $data): User;
}

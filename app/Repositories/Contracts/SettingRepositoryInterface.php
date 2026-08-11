<?php

namespace App\Repositories\Contracts;

use App\Models\Setting;

/**
 * @method Setting|null find(mixed $id)
 * @method Setting|null first()
 */
interface SettingRepositoryInterface extends RepositoryInterface
{
	public function filterByScopes(array $scopes): self;
}

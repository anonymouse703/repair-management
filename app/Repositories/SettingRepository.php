<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class SettingRepository extends BaseRepository implements SettingRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(app(Setting::class));
    }

     public function filterByScopes(array $scopes): self
    {
        return $this->filter(static function (Builder $builder) use ($scopes) {
            $builder->whereIn('scope', $scopes);
        });
    }
}

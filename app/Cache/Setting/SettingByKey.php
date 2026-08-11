<?php

namespace App\Cache\Setting;

use App\Cache\CacheBase;
use App\Cache\Traits\WithHelpers;
use App\Models\Setting as Model;
use App\Repositories\Contracts\SettingRepositoryInterface;

/**
 * @method Model|null fetch()
 * @method Model fetchOrFail()
 * @method static Model|null get(string $settingKey)
 * @method static Model getOrFail(string $settingKey)
 * @method static bool forget(string $settingKey)
 * @method static void refresh(string $settingKey)
 */
class SettingByKey extends CacheBase
{
    use WithHelpers;

    public function __construct(protected string $settingKey)
    {
        parent::__construct("settings.{$this->settingKey}", now()->addHour());
    }

    protected function cacheMiss()
    {
        return app(SettingRepositoryInterface::class)->find($this->settingKey);
    }

    protected function errorModelName(): string
    {
        return 'Setting';
    }

    protected function errorModelId(): string
    {
        return $this->settingKey;
    }
}

<?php

namespace App\Cache\File;

use App\Cache\CacheBase;
use App\Cache\Traits\WithHelpers;
use App\Models\File as Model;
use App\Repositories\Contracts\FileRepositoryInterface;

/**
 * @method Model|null fetch()
 * @method Model fetchOrFail()
 * @method static Model|null get(int $id)
 * @method static Model getOrFail(int $id)
 * @method static bool forget(int $id)
 * @method static void refresh(int $id)
 */
class FileById extends CacheBase
{
    use WithHelpers;

    public function __construct(protected int $id)
    {
        parent::__construct("files.id.{$this->id}", now()->addHour());
    }

    protected function cacheMiss()
    {
        return app(FileRepositoryInterface::class)->find($this->id);
    }

    protected function errorModelName(): string
    {
        return 'File';
    }

    protected function errorModelId(): int
    {
        return $this->id;
    }
}

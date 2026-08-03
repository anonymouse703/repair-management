<?php

namespace App\Cache\Traits;

trait WithHelpers
{
    public static function get(...$params)
    {
        return (new self(...$params))->fetch();
    }

    public static function forget(...$params)
    {
        return (new self(...$params))->invalidate();
    }

    public static function getOrFail(...$params)
    {
        return (new self(...$params))->fetchOrFail();
    }

    public static function refresh(...$params): void
    {
        $self = new self(...$params);
        $self->invalidate();
        $self->fetch();
    }
}

<?php

namespace App\Enums\Traits;

trait HasLabel
{
    public function label(): string
    {
        return str($this->name)
            ->snake()
            // convert to title case
            ->title()
            // replace underscores with spaces
            ->headline()
            // return as string
            ->toString();
    }

}

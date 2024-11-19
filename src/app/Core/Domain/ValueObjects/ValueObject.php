<?php

namespace App\Core\Domain\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

abstract class ValueObject implements Arrayable
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

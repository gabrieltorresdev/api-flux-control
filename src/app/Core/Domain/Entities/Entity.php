<?php

namespace Core\Domain\Entities;

use Illuminate\Contracts\Support\Arrayable;

abstract class Entity implements Arrayable
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

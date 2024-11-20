<?php

namespace App\Core\Domain\Entity;

use Illuminate\Contracts\Support\Arrayable;

abstract class Entity implements Arrayable
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

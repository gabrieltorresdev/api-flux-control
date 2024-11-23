<?php

namespace App\Core\Domain\Entity;

use Exception;
use Illuminate\Contracts\Support\Arrayable;

abstract class Entity implements Arrayable
{
    public function __get($property)
    {
        if (isset($this->{$property})) {
            return $this->{$property};
        }

        $className = get_class($this);
        throw new Exception("Property {$property} not found in class {$className}");
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

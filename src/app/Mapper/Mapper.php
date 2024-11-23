<?php

namespace App\Mapper;

use App\Core\Domain\Entity\Entity;

interface Mapper
{
    public static function fromArray(array|object $data): Entity;
}

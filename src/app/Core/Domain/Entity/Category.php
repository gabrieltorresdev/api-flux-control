<?php

namespace App\Core\Domain\Entity;

use App\Core\Domain\Enum\CategoryType;

class Category extends Entity
{
    public function __construct(
        public string $id,
        public string $name,
        public CategoryType $type,
        public bool $is_default = false
    ) {}
}
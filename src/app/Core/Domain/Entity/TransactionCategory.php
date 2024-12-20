<?php

namespace App\Core\Domain\Entity;

use App\Core\Domain\Enum\TransactionCategoryType;

class TransactionCategory extends Entity
{
    public function __construct(
        public string $id,
        public string $name,
        public TransactionCategoryType $type,
        public bool $is_default = false
    ) {}
}

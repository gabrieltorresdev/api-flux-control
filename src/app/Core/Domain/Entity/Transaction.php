<?php

namespace App\Core\Domain\Entity;

use App\Core\Domain\Enum\TransactionType;
use Carbon\Carbon;

class Transaction extends Entity
{
    public TransactionCategory $category;

    public function __construct(
        public string $id,
        public TransactionType $type,
        public float $amount,
        public Carbon $date,
        public ?string $description
    ) {
    }

    public function setCategory(TransactionCategory $category): void
    {
        $this->category = $category;
    }
}

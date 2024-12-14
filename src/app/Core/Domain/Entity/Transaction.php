<?php

namespace App\Core\Domain\Entity;

use Carbon\Carbon;

class Transaction extends Entity
{
    public TransactionCategory $category;

    public function __construct(
        public string $id,
        public string $title,
        public float $amount,
        public Carbon $dateTime,
    ) {
    }

    public function setCategory(TransactionCategory $category): void
    {
        $this->category = $category;
    }
}

<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\TransactionCategory;
use App\Core\Domain\Enum\TransactionCategoryType;

interface ITransactionCategoryRepository
{
    public function create(string $name, TransactionCategoryType $type): TransactionCategory;
}

<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\Transaction;
use App\Core\Domain\Entity\TransactionCategory;
use App\Core\Domain\Enum\TransactionType;
use Carbon\Carbon;

interface ITransactionRepository
{
    /** @return Transaction[] */
    public function findAll(?TransactionCategory $category, ?Carbon $startDate, ?Carbon $endDate, ?TransactionType $type): array;
}

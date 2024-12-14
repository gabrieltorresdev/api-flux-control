<?php

namespace App\Core\Application\Transaction\DTO\List;

use App\Core\Domain\Enum\TransactionCategoryType;
use App\Shared\ObjectAbstract;

class OutListTransactionCategory extends ObjectAbstract
{
    public string $id;
    public string $name;
    public TransactionCategoryType $type;
}

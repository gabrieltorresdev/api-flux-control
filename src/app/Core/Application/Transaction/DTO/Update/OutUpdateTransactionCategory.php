<?php

namespace App\Core\Application\Transaction\DTO\Update;

use App\Core\Domain\Enum\TransactionCategoryType;
use App\Shared\ObjectAbstract;

class OutUpdateTransactionCategory extends ObjectAbstract
{
    public string $id;
    public string $name;
    public TransactionCategoryType $type;
}

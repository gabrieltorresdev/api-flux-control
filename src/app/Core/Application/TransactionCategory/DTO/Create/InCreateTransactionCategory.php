<?php

namespace App\Core\Application\TransactionCategory\DTO\Create;

use App\Core\Domain\Enum\TransactionCategoryType;
use App\Shared\ObjectAbstract;

class InCreateTransactionCategory extends ObjectAbstract
{
    public string $name;
    public TransactionCategoryType $type;
}

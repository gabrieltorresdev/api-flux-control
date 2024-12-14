<?php

namespace App\Core\Application\Transaction\DTO\Create;

use App\Core\Domain\Enum\TransactionCategoryType;
use App\Shared\ObjectAbstract;

class OutCreateTransactionCategory extends ObjectAbstract
{
    public string $id;
    public string $name;
    public TransactionCategoryType $type;
}

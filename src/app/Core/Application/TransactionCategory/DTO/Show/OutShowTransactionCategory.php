<?php

namespace App\Core\Application\TransactionCategory\DTO\Show;

use App\Core\Domain\Enum\TransactionCategoryType;
use App\Shared\ObjectAbstract;

class OutShowTransactionCategory extends ObjectAbstract
{
    public string $id;
    public string $name;
    public TransactionCategoryType $type;
}

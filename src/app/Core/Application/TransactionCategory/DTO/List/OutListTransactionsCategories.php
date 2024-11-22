<?php

namespace App\Core\Application\TransactionCategory\DTO\List;

use App\Core\Domain\Enum\TransactionCategoryType;
use App\Shared\ObjectAbstract;

class OutListTransactionsCategories extends ObjectAbstract
{
    public string $id;
    public string $name;
    public TransactionCategoryType $type;
}

<?php

namespace App\Core\Application\TransactionCategory\DTO\List;

use App\Core\Domain\Enum\TransactionCategoryType;
use App\Shared\ObjectAbstract;

class InListTransactionsCategories extends ObjectAbstract
{
    public ?string $name;
    public ?TransactionCategoryType $type;
}

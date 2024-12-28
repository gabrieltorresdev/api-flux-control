<?php

namespace App\Core\Application\Transaction\DTO\List;

use App\Core\Domain\Enum\CategoryType;
use App\Shared\ObjectAbstract;

class OutListTransactionCategory extends ObjectAbstract
{
    public string $id;
    public string $name;
    public CategoryType $type;
}

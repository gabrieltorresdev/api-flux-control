<?php

namespace App\Core\Application\Transaction\DTO\Update;

use App\Core\Domain\Enum\CategoryType;
use App\Shared\ObjectAbstract;

class OutUpdateTransactionCategory extends ObjectAbstract
{
    public string $id;
    public string $name;
    public CategoryType $type;
    public ?string $icon;
}

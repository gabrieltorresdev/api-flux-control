<?php

namespace App\Core\Application\Transaction\DTO\List;

use App\Core\Domain\Entity\TransactionCategory;
use App\Core\Domain\Enum\TransactionType;
use App\Shared\ObjectAbstract;
use Carbon\Carbon;

class InListTransaction extends ObjectAbstract
{
    public ?TransactionCategory $category;
    public ?Carbon $startDate;
    public ?Carbon $endDate;
    public ?TransactionType $type;
}

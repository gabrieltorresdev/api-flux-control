<?php

namespace App\Core\Application\Transaction\DTO\Create;

use App\Core\Domain\Entity\TransactionCategory;
use App\Core\Domain\Enum\TransactionType;
use App\Shared\ObjectAbstract;
use Carbon\Carbon;

class OutCreateTransaction extends ObjectAbstract
{
    public string $id;
    public TransactionCategory $category;
    public float $amount;
    public TransactionType $type;
    public Carbon $date;
    public ?string $description;
}

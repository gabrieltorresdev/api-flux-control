<?php

namespace App\Core\Application\Transaction\DTO\Create;

use App\Core\Domain\Enum\TransactionType;
use App\Shared\ObjectAbstract;
use Carbon\Carbon;

class InCreateTransaction extends ObjectAbstract
{
    public string $category_id;
    public float $amount;
    public TransactionType $type;
    public Carbon $date;
    public ?string $description;
}

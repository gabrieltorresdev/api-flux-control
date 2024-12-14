<?php

namespace App\Core\Application\Transaction\DTO\Create;

use App\Shared\ObjectAbstract;
use Carbon\Carbon;

class OutCreateTransaction extends ObjectAbstract
{
    public string $id;
    public OutCreateTransactionCategory $category;
    public string $title;
    public float $amount;
    public Carbon $dateTime;
}

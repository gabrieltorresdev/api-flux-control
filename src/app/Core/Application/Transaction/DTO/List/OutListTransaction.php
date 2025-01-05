<?php

namespace App\Core\Application\Transaction\DTO\List;

use App\Shared\ObjectAbstract;
use Carbon\Carbon;

class OutListTransaction extends ObjectAbstract
{
    public string $id;
    public OutListTransactionCategory $category;
    public string $title;
    public float $amount;
    public Carbon $dateTime;
}

<?php

namespace App\Core\Application\Transaction\DTO\Update;

use App\Shared\ObjectAbstract;
use Carbon\Carbon;

class OutUpdateTransaction extends ObjectAbstract
{
    public string $id;
    public OutUpdateTransactionCategory $category;
    public string $title;
    public float $amount;
    public Carbon $dateTime;
}

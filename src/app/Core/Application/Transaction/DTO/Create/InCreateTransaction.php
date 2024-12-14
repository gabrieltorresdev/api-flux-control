<?php

namespace App\Core\Application\Transaction\DTO\Create;

use App\Shared\ObjectAbstract;
use Carbon\Carbon;

class InCreateTransaction extends ObjectAbstract
{
    public string $categoryId;
    public string $title;
    public float $amount;
    public Carbon $dateTime;
}

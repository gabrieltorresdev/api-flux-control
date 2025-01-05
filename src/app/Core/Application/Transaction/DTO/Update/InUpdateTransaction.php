<?php

namespace App\Core\Application\Transaction\DTO\Update;

use App\Shared\ObjectAbstract;
use Carbon\Carbon;

class InUpdateTransaction extends ObjectAbstract
{
    public string $id;
    public string $userId;
    public string $categoryId;
    public string $title;
    public float $amount;
    public Carbon $dateTime;
}

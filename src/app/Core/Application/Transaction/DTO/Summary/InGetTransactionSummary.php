<?php

namespace App\Core\Application\Transaction\DTO\Summary;

use App\Shared\ObjectAbstract;
use Carbon\Carbon;

class InGetTransactionSummary extends ObjectAbstract
{
    public string $userId;
    public ?Carbon $startDate;
    public ?Carbon $endDate;
    public ?string $categoryId;
    public ?string $search;
}

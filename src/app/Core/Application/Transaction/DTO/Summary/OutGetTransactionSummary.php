<?php

namespace App\Core\Application\Transaction\DTO\Summary;

use App\Shared\ObjectAbstract;

class OutGetTransactionSummary extends ObjectAbstract
{
    public float $income;
    public float $expense;
    public float $total;
}

<?php

namespace App\Core\Application\Transaction\DTO\Delete;

use App\Shared\ObjectAbstract;

class InDeleteTransaction extends ObjectAbstract
{
    public string $userId;
    public string $id;
}

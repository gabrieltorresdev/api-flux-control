<?php

namespace App\Core\Application\Dashboard\DTO\GetInsights;

use App\Shared\ObjectAbstract;
use Carbon\Carbon;

class InGetInsights extends ObjectAbstract
{
    public string $userId;
    public ?Carbon $startDate;
    public ?Carbon $endDate;
} 
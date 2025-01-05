<?php

namespace App\Core\Application\Transaction\DTO\List;

use App\Core\Domain\Enum\CategoryType;
use App\Shared\ObjectAbstract;
use Carbon\Carbon;

class InListTransaction extends ObjectAbstract
{
    public string $userId;
    public ?string $search;
    public ?string $categoryId;
    public ?CategoryType $type;
    public ?Carbon $startDate;
    public ?Carbon $endDate;
    public ?int $perPage;
}

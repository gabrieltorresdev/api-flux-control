<?php

namespace App\Core\Application\Dashboard\DTO\GetInsights;

use App\Core\Domain\Enum\InsightType;
use App\Shared\ObjectAbstract;

class OutGetInsights extends ObjectAbstract
{
    public InsightType $type;
    public string $category;
    public string $title;
    public string $description;
    public array $comparison;
    public array $metadata;
}
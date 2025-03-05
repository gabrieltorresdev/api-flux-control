<?php

namespace App\Core\Domain\Entity;

use App\Core\Domain\Enum\InsightType;
use Carbon\Carbon;

class Insight extends Entity
{
    public function __construct(
        public string $id,
        public InsightType $type,
        public string $category,
        public string $title,
        public string $description,
        public array $comparison,
        public array $metadata
    ) {}
} 
<?php

namespace App\Core\Domain\Service;

use App\Core\Domain\Entity\Insight;
use Carbon\Carbon;

interface IInsightAnalyzer
{
    public function analyze(string $userId, Carbon $startDate, Carbon $endDate): ?Insight;
} 
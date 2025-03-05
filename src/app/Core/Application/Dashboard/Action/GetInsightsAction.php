<?php

namespace App\Core\Application\Dashboard\Action;

use App\Core\Application\Dashboard\DTO\GetInsights\InGetInsights;
use App\Core\Application\Dashboard\DTO\GetInsights\OutGetInsights;
use App\Core\Domain\Service\IInsightAnalyzer;
use Carbon\Carbon;
use Exception;

readonly class GetInsightsAction
{
    /**
     * @param IInsightAnalyzer[] $analyzers
     */
    public function __construct(private array $analyzers)
    {
        foreach ($analyzers as $analyzer) {
            if (!($analyzer instanceof IInsightAnalyzer)) {
                throw new Exception('Invalid analyzer type');
            }
        }
    }

    /**
     * @return OutGetInsights[]
     */
    public function execute(InGetInsights $data): array
    {
        $startDate = $data->startDate ?? Carbon::now()->startOfMonth();
        $endDate = $data->endDate ?? Carbon::now();

        $insights = [];
        foreach ($this->analyzers as $analyzer) {
            $insight = $analyzer->analyze($data->userId, $startDate, $endDate);
            if ($insight !== null) {
                $insights[] = $insight;
            }
        }

        return OutGetInsights::arrayOf($insights);
    }
} 
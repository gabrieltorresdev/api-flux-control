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

            // Add test insights for all possible types
            $insights[] = new \App\Core\Domain\Entity\Insight(
                id: \Ramsey\Uuid\Uuid::uuid4()->toString(),
                type: \App\Core\Domain\Enum\InsightType::DANGER,
                category: 'Test Category 1',
                title: 'Test Danger Insight',
                description: 'This is a test danger insight',
                comparison: [
                    'current' => 100,
                    'previous' => 200,
                    'percentageChange' => -50
                ],
                metadata: [
                    'period' => $startDate->format('Y-m'),
                    'actionUrl' => '/test/url',
                    'actionLabel' => 'View Details'
                ]
            );

            $insights[] = new \App\Core\Domain\Entity\Insight(
                id: \Ramsey\Uuid\Uuid::uuid4()->toString(), 
                type: \App\Core\Domain\Enum\InsightType::WARNING,
                category: 'Test Category 2',
                title: 'Test Warning Insight',
                description: 'This is a test warning insight',
                comparison: [
                    'current' => 300,
                    'previous' => 200,
                    'percentageChange' => 50
                ],
                metadata: [
                    'period' => $startDate->format('Y-m'),
                    'actionUrl' => '/test/url',
                    'actionLabel' => 'View Details'
                ]
            );

            $insights[] = new \App\Core\Domain\Entity\Insight(
                id: \Ramsey\Uuid\Uuid::uuid4()->toString(),
                type: \App\Core\Domain\Enum\InsightType::INFO,
                category: 'Test Category 3', 
                title: 'Test Info Insight',
                description: 'This is a test info insight',
                comparison: [
                    'current' => 150,
                    'previous' => 100,
                    'percentageChange' => 50
                ],
                metadata: [
                    'period' => $startDate->format('Y-m'),
                    'actionUrl' => '/test/url',
                    'actionLabel' => 'View Details'
                ]
            );
        }

        return OutGetInsights::arrayOf($insights);
    }
} 
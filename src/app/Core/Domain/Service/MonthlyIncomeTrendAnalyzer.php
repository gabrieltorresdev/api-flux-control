<?php

namespace App\Core\Domain\Service;

use App\Core\Domain\Entity\Insight;
use App\Core\Domain\Enum\CategoryType;
use App\Core\Domain\Enum\InsightType;
use App\Core\Domain\Repository\ITransactionRepository;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

readonly class MonthlyIncomeTrendAnalyzer implements IInsightAnalyzer
{
    public function __construct(
        private ITransactionRepository $transactionRepository
    ) {}

    public function analyze(string $userId, Carbon $startDate, Carbon $endDate): ?Insight
    {
        // Get current month summary
        $currentSummary = $this->transactionRepository->getSummary(
            $userId,
            $startDate,
            $endDate
        );

        // Get previous month summary
        $previousMonthStart = (clone $startDate)->subMonth();
        $previousMonthEnd = (clone $endDate)->subMonth();
        $previousSummary = $this->transactionRepository->getSummary(
            $userId,
            $previousMonthStart,
            $previousMonthEnd
        );

        if (!isset($currentSummary['income']) || !isset($previousSummary['income']) || $previousSummary['income'] == 0) {
            return null;
        }

        $percentageChange = (($currentSummary['income'] - $previousSummary['income']) / $previousSummary['income']) * 100;
        $difference = abs($currentSummary['income'] - $previousSummary['income']);

        // Only show significant changes
        if (abs($percentageChange) < 5) {
            return null;
        }

        $type = $percentageChange > 0 ? InsightType::SUCCESS : InsightType::WARNING;
        $title = $percentageChange > 0 
            ? 'Tendência de crescimento nas receitas' 
            : 'Tendência de queda nas receitas';
        
        $direction = $percentageChange > 0 ? 'aumentaram' : 'diminuíram';
        $description = "Suas receitas totais {$direction} em " . abs(round($percentageChange, 1)) . 
                       "% em comparação ao mês anterior, " . 
                       ($percentageChange > 0 
                           ? "representando R$ " . number_format($difference, 2, ',', '.') . " a mais em rendimentos" 
                           : "significando uma redução de R$ " . number_format($difference, 2, ',', '.') . " em seus rendimentos") . ".";

        return new Insight(
            id: Uuid::uuid4()->toString(),
            type: $type,
            category: 'Receitas',
            title: $title,
            description: $description,
            comparison: [
                'current' => $currentSummary['income'],
                'previous' => $previousSummary['income'],
                'percentageChange' => round($percentageChange, 2)
            ],
            metadata: [
                'period' => $startDate->format('Y-m'),
                'actionUrl' => "/dashboard/transactions?type=income",
                'actionLabel' => "Visualizar todas as receitas"
            ]
        );
    }
} 
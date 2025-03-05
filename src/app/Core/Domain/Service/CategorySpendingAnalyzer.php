<?php

namespace App\Core\Domain\Service;

use App\Core\Domain\Entity\Insight;
use App\Core\Domain\Enum\InsightType;
use App\Core\Domain\Repository\ITransactionRepository;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

readonly class CategorySpendingAnalyzer implements IInsightAnalyzer
{
    public function __construct(
        private ITransactionRepository $transactionRepository
    ) {}

    public function analyze(string $userId, Carbon $startDate, Carbon $endDate): ?Insight
    {
        $currentPeriodData = $this->transactionRepository->getCategorySpendingSummary(
            $userId,
            $startDate,
            $endDate
        );

        $previousPeriodStart = (clone $startDate)->subMonth();
        $previousPeriodEnd = (clone $endDate)->subMonth();

        $previousPeriodData = $this->transactionRepository->getCategorySpendingSummary(
            $userId,
            $previousPeriodStart,
            $previousPeriodEnd
        );

        $insights = [];
        foreach ($currentPeriodData as $categoryData) {
            $previousAmount = $previousPeriodData[$categoryData['id']] ?? ['amount' => 0];
            
            if ($previousAmount['amount'] === 0) {
                continue;
            }

            $percentageChange = (($categoryData['amount'] - $previousAmount['amount']) / $previousAmount['amount']) * 100;
            
            if (abs($percentageChange) >= 10) {
                $insights[] = new Insight(
                    id: Uuid::uuid4()->toString(),
                    type: $percentageChange < 0 ? InsightType::SUCCESS : InsightType::WARNING,
                    category: $categoryData['name'],
                    title: $this->generateTitle($categoryData['name'], $percentageChange),
                    description: $this->generateDescription($categoryData['name'], $percentageChange, abs($categoryData['amount'] - $previousAmount['amount'])),
                    comparison: [
                        'current' => $categoryData['amount'],
                        'previous' => $previousAmount['amount'],
                        'percentageChange' => round($percentageChange, 2)
                    ],
                    metadata: [
                        'period' => $startDate->format('Y-m'),
                        'actionUrl' => "/dashboard/transactions?categoryId={$categoryData['id']}",
                        'actionLabel' => $this->generateActionLabel($categoryData['name'])
                    ]
                );
            }
        }

        return $insights[0] ?? null;
    }

    private function generateTitle(string $category, float $percentageChange): string
    {
        $action = $percentageChange < 0 ? 'Redução' : 'Aumento';
        return "Gastos com {$category} - {$action}";
    }

    private function generateDescription(string $category, float $percentageChange, float $difference): string
    {
        $direction = $percentageChange < 0 ? 'reduziram' : 'aumentaram';
        return "Seus gastos com {$category} {$direction} em " . 
               abs(round($percentageChange, 1)) . "% comparado ao mês anterior, " .
               ($percentageChange < 0 ? "economizando" : "gastando a mais") . 
               " R$ " . number_format($difference, 2, ',', '.');
    }

    private function generateActionLabel(string $category): string
    {
        return "Ver gastos de {$category}";
    }
} 
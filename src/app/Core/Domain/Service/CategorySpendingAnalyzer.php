<?php

namespace App\Core\Domain\Service;

use App\Core\Domain\Entity\Insight;
use App\Core\Domain\Enum\CategoryType;
use App\Core\Domain\Enum\InsightType;
use App\Core\Domain\Repository\ICategoryRepository;
use App\Core\Domain\Repository\ITransactionRepository;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

readonly class CategorySpendingAnalyzer implements IInsightAnalyzer
{
    public function __construct(
        private ITransactionRepository $transactionRepository,
        private ICategoryRepository $categoryRepository
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
            $category = $this->categoryRepository->findById($userId, $categoryData['id']);
            if (!$category) continue;

            $previousAmount = $previousPeriodData[$categoryData['id']] ?? ['amount' => 0];
            
            if ($previousAmount['amount'] === 0) {
                continue;
            }

            $percentageChange = (($categoryData['amount'] - $previousAmount['amount']) / $previousAmount['amount']) * 100;
            
            if (abs($percentageChange) >= 10) {
                $isExpenseCategory = $category->type === CategoryType::EXPENSE;
                $isPositiveChange = $isExpenseCategory ? $percentageChange < 0 : $percentageChange > 0;
                
                $insightType = $isPositiveChange ? InsightType::SUCCESS : InsightType::WARNING;
                
                $insights[] = new Insight(
                    id: Uuid::uuid4()->toString(),
                    type: $insightType,
                    category: $categoryData['name'],
                    title: $this->generateTitle($categoryData['name'], $percentageChange, $category->type),
                    description: $this->generateDescription($categoryData['name'], $percentageChange, abs($categoryData['amount'] - $previousAmount['amount']), $category->type),
                    comparison: [
                        'current' => $categoryData['amount'],
                        'previous' => $previousAmount['amount'],
                        'percentageChange' => round($percentageChange, 2)
                    ],
                    metadata: [
                        'period' => $startDate->format('Y-m'),
                        'actionUrl' => "/dashboard/transactions?categoryId={$categoryData['id']}",
                        'actionLabel' => $this->generateActionLabel($categoryData['name'], $category->type)
                    ]
                );
            }
        }

        return $insights[0] ?? null;
    }

    private function generateTitle(string $category, float $percentageChange, CategoryType $type): string
    {
        if ($type === CategoryType::EXPENSE) {
            $action = $percentageChange < 0 ? 'Redução nos gastos' : 'Aumento nos gastos';
            return "{$action} com {$category}";
        } else {
            $action = $percentageChange > 0 ? 'Crescimento nas receitas' : 'Redução nas receitas';
            return "{$action} de {$category}";
        }
    }

    private function generateDescription(string $category, float $percentageChange, float $difference, CategoryType $type): string
    {
        if ($type === CategoryType::EXPENSE) {
            $direction = $percentageChange < 0 ? 'reduziram' : 'aumentaram';
            $impact = $percentageChange < 0 ? "economia de" : "gasto adicional de";
            return "Seus gastos relacionados a {$category} {$direction} em " . 
                   abs(round($percentageChange, 1)) . "% em comparação ao mês anterior, " .
                   "gerando {$impact} R$ " . number_format($difference, 2, ',', '.');
        } else {
            $direction = $percentageChange > 0 ? 'aumentaram' : 'diminuíram';
            $impact = $percentageChange > 0 ? "ganho adicional de" : "redução de";
            return "Suas receitas provenientes de {$category} {$direction} em " . 
                   abs(round($percentageChange, 1)) . "% em comparação ao mês anterior, " .
                   "resultando em um {$impact} R$ " . number_format($difference, 2, ',', '.');
        }
    }

    private function generateActionLabel(string $category, CategoryType $type): string
    {
        return $type === CategoryType::EXPENSE 
            ? "Visualizar transações de {$category}" 
            : "Visualizar receitas de {$category}";
    }
} 
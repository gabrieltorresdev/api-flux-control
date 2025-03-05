<?php

namespace App\Core\Domain\Service;

use App\Core\Domain\Entity\Insight;
use App\Core\Domain\Enum\CategoryType;
use App\Core\Domain\Enum\InsightType;
use App\Core\Domain\Repository\ITransactionRepository;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

readonly class TopSpendingCategoryAnalyzer implements IInsightAnalyzer
{
    public function __construct(
        private ITransactionRepository $transactionRepository
    ) {}

    public function analyze(string $userId, Carbon $startDate, Carbon $endDate): ?Insight
    {
        $categoryData = $this->transactionRepository->getCategorySpendingSummary(
            $userId,
            $startDate,
            $endDate
        );

        if (empty($categoryData)) {
            return null;
        }

        // Get total expenses for calculation of percentage
        $currentSummary = $this->transactionRepository->getSummary(
            $userId,
            $startDate,
            $endDate
        );
        
        if ($currentSummary['expense'] <= 0) {
            return null;
        }

        // Filter to only expense categories and sort by amount
        $expenseCategories = [];
        foreach ($categoryData as $category) {
            // Check if the category is an expense using the type field
            if (isset($category['type']) && $category['type'] === CategoryType::EXPENSE->value) {
                $expenseCategories[] = $category;
            }
        }

        if (empty($expenseCategories)) {
            return null;
        }
        
        // Sort by amount descending
        usort($expenseCategories, fn($a, $b) => $b['amount'] <=> $a['amount']);
        
        // Get the top category
        $topCategory = $expenseCategories[0];
        $percentageOfTotal = ($topCategory['amount'] / $currentSummary['expense']) * 100;
        
        // Only show if it's significant (more than 25% of expenses)
        if ($percentageOfTotal < 25) {
            return null;
        }

        return new Insight(
            id: Uuid::uuid4()->toString(),
            type: InsightType::INFO,
            category: $topCategory['name'],
            title: "Principal categoria de despesa: {$topCategory['name']}",
            description: "No período analisado, você destinou R$ " . number_format($topCategory['amount'], 2, ',', '.') . 
                         " para {$topCategory['name']}, o que corresponde a " . 
                         round($percentageOfTotal, 1) . "% do total das suas despesas. " .
                         ($percentageOfTotal > 40 ? "Este valor representa uma parcela significativa do seu orçamento." : ""),
            comparison: [
                'amount' => $topCategory['amount'],
                'totalExpenses' => $currentSummary['expense'],
                'percentage' => round($percentageOfTotal, 2)
            ],
            metadata: [
                'period' => $startDate->format('Y-m'),
                'actionUrl' => "/dashboard/transactions?categoryId={$topCategory['id']}",
                'actionLabel' => "Visualizar detalhes de {$topCategory['name']}"
            ]
        );
    }
} 
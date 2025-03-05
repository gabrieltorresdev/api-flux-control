<?php

namespace App\Core\Domain\Service;

use App\Core\Domain\Entity\Insight;
use App\Core\Domain\Enum\InsightType;
use App\Core\Domain\Repository\ITransactionRepository;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

readonly class BudgetBalanceAnalyzer implements IInsightAnalyzer
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

        if ($currentSummary['income'] == 0 && $currentSummary['expense'] == 0) {
            return null;
        }

        // Evaluate budget health
        $balance = $currentSummary['income'] - $currentSummary['expense'];
        $savingsRate = $currentSummary['income'] > 0 
            ? ($balance / $currentSummary['income']) * 100 
            : 0;

        // Determine insight type based on savings rate
        $insightType = InsightType::INFO;
        if ($savingsRate >= 20) {
            $insightType = InsightType::SUCCESS;
        } elseif ($savingsRate < 0) {
            $insightType = InsightType::DANGER;
        } elseif ($savingsRate < 10) {
            $insightType = InsightType::WARNING;
        }

        $title = $this->generateTitle($savingsRate);
        $description = $this->generateDescription($balance, $savingsRate, $currentSummary);

        return new Insight(
            id: Uuid::uuid4()->toString(),
            type: $insightType,
            category: 'Balanço Financeiro',
            title: $title,
            description: $description,
            comparison: [
                'income' => $currentSummary['income'],
                'expense' => $currentSummary['expense'],
                'balance' => $balance,
                'savingsRate' => round($savingsRate, 2)
            ],
            metadata: [
                'period' => $startDate->format('Y-m'),
                'actionUrl' => "/dashboard/transactions",
                'actionLabel' => "Ver todas as transações"
            ]
        );
    }

    private function generateTitle(float $savingsRate): string
    {
        if ($savingsRate >= 20) {
            return "Ótimo equilíbrio financeiro!";
        } elseif ($savingsRate >= 10) {
            return "Bom equilíbrio financeiro";
        } elseif ($savingsRate >= 0) {
            return "Orçamento equilibrado";
        } else {
            return "Despesas excedendo receitas";
        }
    }

    private function generateDescription(float $balance, float $savingsRate, array $summary): string
    {
        $formattedBalance = number_format(abs($balance), 2, ',', '.');
        
        if ($balance > 0) {
            return "Você economizou R$ {$formattedBalance} neste período, " .
                   "o que representa " . round($savingsRate, 1) . "% da sua receita total. " .
                   ($savingsRate >= 20 
                       ? "Continue com este excelente trabalho!" 
                       : "Procure economizar pelo menos 20% da sua receita para uma saúde financeira ideal.");
        } else {
            return "Suas despesas excederam sua receita em R$ {$formattedBalance} neste período. " .
                   "Recomendamos revisar seus gastos para equilibrar seu orçamento e evitar endividamento.";
        }
    }
} 
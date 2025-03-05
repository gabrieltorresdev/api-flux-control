<?php

namespace App\Core\Domain\Service;

use App\Core\Domain\Entity\Insight;
use App\Core\Domain\Enum\InsightType;
use App\Core\Domain\Repository\ITransactionRepository;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

readonly class MonthlyGrowthRateAnalyzer implements IInsightAnalyzer
{
    private const MONTHS_TO_ANALYZE = 3;

    public function __construct(
        private ITransactionRepository $transactionRepository
    ) {}

    public function analyze(string $userId, Carbon $startDate, Carbon $endDate): ?Insight
    {
        // Need at least 3 months of data for meaningful growth analysis
        $monthlyTotals = [];
        
        // Get current month data
        $currentMonthSummary = $this->transactionRepository->getSummary(
            $userId,
            $startDate,
            $endDate
        );
        
        if ($currentMonthSummary['income'] <= 0) {
            return null;
        }
        
        $monthlyTotals[] = $currentMonthSummary['income'];
        
        // Get previous months data
        for ($i = 1; $i < self::MONTHS_TO_ANALYZE; $i++) {
            $previousMonthStart = (clone $startDate)->subMonths($i)->startOfMonth();
            $previousMonthEnd = (clone $previousMonthStart)->endOfMonth();
            
            $monthSummary = $this->transactionRepository->getSummary(
                $userId,
                $previousMonthStart,
                $previousMonthEnd
            );
            
            // If any month has no data, we can't calculate growth rate
            if ($monthSummary['income'] <= 0) {
                return null;
            }
            
            $monthlyTotals[] = $monthSummary['income'];
        }
        
        // Calculate average monthly growth rate
        $growthRates = [];
        for ($i = 0; $i < count($monthlyTotals) - 1; $i++) {
            $currentMonth = $monthlyTotals[$i];
            $previousMonth = $monthlyTotals[$i + 1];
            
            $growthRate = (($currentMonth - $previousMonth) / $previousMonth) * 100;
            $growthRates[] = $growthRate;
        }
        
        $averageGrowthRate = array_sum($growthRates) / count($growthRates);
        
        // Only show if there's a significant trend (positive or negative)
        if (abs($averageGrowthRate) < 5) {
            return null;
        }
        
        $insightType = $averageGrowthRate > 0 ? InsightType::SUCCESS : InsightType::WARNING;
        
        $title = $averageGrowthRate > 0 
            ? "Tendência consistente de crescimento nas receitas" 
            : "Tendência de declínio nas receitas ao longo do tempo";
            
        $direction = $averageGrowthRate > 0 ? "crescendo" : "diminuindo";
        $description = "Suas receitas mensais estão {$direction} a uma taxa média de " . 
                       abs(round($averageGrowthRate, 1)) . "% ao mês nos últimos " . 
                       self::MONTHS_TO_ANALYZE . " meses. " .
                       ($averageGrowthRate > 0 
                           ? "Este é um indicador positivo da sua saúde financeira." 
                           : "Recomendamos avaliar estratégias para aumentar suas fontes de renda.");
        
        return new Insight(
            id: Uuid::uuid4()->toString(),
            type: $insightType,
            category: 'Análise de Tendência',
            title: $title,
            description: $description,
            comparison: [
                'monthlyTotals' => array_reverse($monthlyTotals),
                'growthRates' => array_reverse($growthRates),
                'averageGrowthRate' => round($averageGrowthRate, 2)
            ],
            metadata: [
                'period' => $startDate->format('Y-m'),
                'actionUrl' => "/dashboard/transactions?type=income",
                'actionLabel' => "Visualizar histórico de receitas"
            ]
        );
    }
} 
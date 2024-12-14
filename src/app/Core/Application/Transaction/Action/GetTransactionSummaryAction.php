<?php

namespace App\Core\Application\Transaction\Action;

use App\Core\Application\Transaction\DTO\Summary\InGetTransactionSummary;
use App\Core\Application\Transaction\DTO\Summary\OutGetTransactionSummary;
use App\Core\Domain\Repository\ITransactionRepository;
use Exception;

readonly class GetTransactionSummaryAction
{
    public function __construct(private ITransactionRepository $repository)
    {}

    /**
     * @throws Exception
     */
    public function execute(InGetTransactionSummary $data): OutGetTransactionSummary
    {
        return OutGetTransactionSummary::from($this->repository->getSummary(
            $data->startDate,
            $data->endDate
        ));
    }
}

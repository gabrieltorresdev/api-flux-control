<?php

namespace App\Core\Application\Transaction\Action;

use App\Core\Application\Transaction\DTO\List\InListTransaction;
use App\Core\Application\Transaction\DTO\List\OutListTransaction;
use App\Core\Domain\Repository\ITransactionRepository;
use Exception;

readonly class ListTransactionAction
{
    public function __construct(private ITransactionRepository $repository)
    {}

    /**
     * @return OutListTransaction[]
     * @throws Exception
     */
    public function execute(InListTransaction $data): array
    {
        return OutListTransaction::arrayOf($this->repository->findAll(
            $data->category,
            $data->startDate,
            $data->endDate,
            $data->type
        ));
    }
}

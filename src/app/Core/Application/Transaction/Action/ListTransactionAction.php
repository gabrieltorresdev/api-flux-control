<?php

namespace App\Core\Application\Transaction\Action;

use App\Core\Application\Transaction\DTO\List\InListTransaction;
use App\Core\Application\Transaction\DTO\List\OutListTransaction;
use App\Core\Domain\Repository\ITransactionRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class ListTransactionAction
{
    public function __construct(private ITransactionRepository $repository)
    {}

    /**
     * @return LengthAwarePaginator<OutListTransaction>
     * @throws Exception
     */
    public function execute(InListTransaction $data): LengthAwarePaginator
    {
        return $this->repository->findAll(
            $data->search,
            $data->categoryId,
            $data->type,
            $data->startDate,
            $data->endDate,
            $data->perPage
        )->through(fn ($transaction) => OutListTransaction::from($transaction));
    }
}

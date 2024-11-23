<?php

namespace App\Core\Application\Transaction\Action;

use App\Core\Application\Transaction\DTO\Create\InCreateTransaction;
use App\Core\Application\Transaction\DTO\Create\OutCreateTransaction;
use App\Core\Domain\Repository\ITransactionRepository;
use Exception;

readonly class CreateTransactionAction
{
    public function __construct(private ITransactionRepository $repository)
    {}

    /**
     * @throws Exception
     */
    public function execute(InCreateTransaction $data): OutCreateTransaction
    {
        return OutCreateTransaction::from($this->repository->create(
            $data->category_id,
            $data->amount,
            $data->date,
            $data->type,
            $data->description,
        ));
    }
}

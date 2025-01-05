<?php

namespace App\Core\Application\Transaction\Action;

use App\Core\Application\Transaction\DTO\Update\InUpdateTransaction;
use App\Core\Application\Transaction\DTO\Update\OutUpdateTransaction;
use App\Core\Domain\Repository\ITransactionRepository;
use Exception;

readonly class UpdateTransactionAction
{
    public function __construct(private ITransactionRepository $repository) {}

    /**
     * @throws Exception
     */
    public function execute(InUpdateTransaction $data): OutUpdateTransaction
    {
        return OutUpdateTransaction::from($this->repository->update(
            $data->userId,
            $data->id,
            $data->categoryId,
            $data->title,
            $data->amount,
            $data->dateTime,
        ));
    }
}

<?php

namespace App\Core\Application\Transaction\Action;

use App\Core\Application\Transaction\DTO\Delete\InDeleteTransaction;
use App\Core\Domain\Repository\ITransactionRepository;
use Exception;

readonly class DeleteTransactionAction
{
    public function __construct(private ITransactionRepository $repository) {}

    /**
     * @throws Exception
     */
    public function execute(InDeleteTransaction $data): void
    {
        $this->repository->delete($data->userId, $data->id);
    }
}

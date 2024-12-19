<?php

namespace App\Core\Application\Transaction\Action;

use App\Core\Domain\Repository\ITransactionRepository;
use Exception;

readonly class DeleteTransactionAction
{
    public function __construct(private ITransactionRepository $repository) {}

    /**
     * @throws Exception
     */
    public function execute(string $id): void
    {
        $this->repository->delete($id);
    }
}

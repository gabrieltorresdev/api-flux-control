<?php

namespace App\Core\Application\TransactionCategory\Action;

use App\Core\Domain\Repository\ITransactionCategoryRepository;

readonly class DeleteTransactionCategoryAction
{
    public function __construct(
        private ITransactionCategoryRepository $transactionCategoryRepository
    ) {}

    public function execute(string $id): void
    {
        $this->transactionCategoryRepository->delete($id);
    }
}

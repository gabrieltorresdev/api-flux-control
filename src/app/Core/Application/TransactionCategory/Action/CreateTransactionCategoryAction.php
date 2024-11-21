<?php

namespace App\Core\Application\TransactionCategory\Action;

use App\Core\Application\TransactionCategory\DTO\Create\InCreateTransactionCategory;
use App\Core\Application\TransactionCategory\DTO\Create\OutCreateTransactionCategory;
use App\Core\Domain\Repository\ITransactionCategoryRepository;

readonly class CreateTransactionCategoryAction
{
    public function __construct(
        private ITransactionCategoryRepository $transactionCategoryRepository
    ) {
    }

    public function execute(InCreateTransactionCategory $data): OutCreateTransactionCategory
    {
        return OutCreateTransactionCategory::from($this->transactionCategoryRepository->create(
            $data->name,
            $data->type
        ));
    }
}

<?php

namespace App\Core\Application\TransactionCategory\Action;

use App\Core\Application\TransactionCategory\DTO\List\InListTransactionsCategories;
use App\Core\Application\TransactionCategory\DTO\List\OutListTransactionsCategories;
use App\Core\Domain\Repository\ITransactionCategoryRepository;

readonly class ListTransactionsCategoriesAction
{
    public function __construct(
        private ITransactionCategoryRepository $transactionCategoryRepository
    ) {
    }

    /** @return OutListTransactionsCategories[] */
    public function execute(InListTransactionsCategories $data): array
    {
        return OutListTransactionsCategories::arrayOf($this->transactionCategoryRepository->index($data->name, $data->type));
    }
}

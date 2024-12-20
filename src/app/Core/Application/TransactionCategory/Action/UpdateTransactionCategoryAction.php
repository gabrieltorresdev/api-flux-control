<?php

namespace App\Core\Application\TransactionCategory\Action;

use App\Core\Application\TransactionCategory\DTO\Update\InUpdateTransactionCategory;
use App\Core\Application\TransactionCategory\DTO\Update\OutUpdateTransactionCategory;
use App\Core\Domain\Repository\ITransactionCategoryRepository;

readonly class UpdateTransactionCategoryAction
{
    public function __construct(
        private ITransactionCategoryRepository $transactionCategoryRepository
    ) {}

    public function execute(InUpdateTransactionCategory $data): OutUpdateTransactionCategory
    {
        return OutUpdateTransactionCategory::from(
            $this->transactionCategoryRepository->update(
                $data->id,
                $data->name,
                $data->type
            )
        );
    }
}

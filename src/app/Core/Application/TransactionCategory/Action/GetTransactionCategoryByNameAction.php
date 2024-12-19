<?php

namespace App\Core\Application\TransactionCategory\Action;

use App\Core\Application\TransactionCategory\DTO\Show\OutShowTransactionCategory;
use App\Core\Domain\Repository\ITransactionCategoryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class GetTransactionCategoryByNameAction
{
    public function __construct(
        private ITransactionCategoryRepository $transactionCategoryRepository
    ) {}

    public function execute(string $name): OutShowTransactionCategory
    {
        $result = $this->transactionCategoryRepository->findByName($name);

        if (!$result) {
            throw new NotFoundHttpException('Transaction Category not found!');
        }

        return OutShowTransactionCategory::from($result);
    }
}

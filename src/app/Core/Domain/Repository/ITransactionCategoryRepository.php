<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\TransactionCategory;
use App\Core\Domain\Enum\TransactionCategoryType;

interface ITransactionCategoryRepository
{
    /** @return TransactionCategory[] */
    public function index(?string $name, ?TransactionCategoryType $type): array;
    public function create(string $name, TransactionCategoryType $type): TransactionCategory;
    public function findByName(string $name): ?TransactionCategory;
    public function delete(string $id): void;
    public function update(string $id, string $name, TransactionCategoryType $type): TransactionCategory;
}

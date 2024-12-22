<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\Transaction;
use App\Core\Domain\Entity\TransactionCategory;
use App\Core\Domain\Enum\TransactionCategoryType;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ITransactionRepository
{
    /** @return LengthAwarePaginator<Transaction> */
    public function findAll(?string $search, ?string $categoryId, ?TransactionCategoryType $type, ?Carbon $startDate, ?Carbon $endDate, int $perPage): LengthAwarePaginator;
    public function create(string $categoryId, string $title, float $amount, Carbon $dateTime): Transaction;
    public function update(string $id, string $categoryId, string $title, float $amount, Carbon $dateTime): Transaction;
    public function delete(string $id): void;
    public function getSummary(?Carbon $startDate, ?Carbon $endDate, ?string $categoryId = null, ?string $search = null): array;
}

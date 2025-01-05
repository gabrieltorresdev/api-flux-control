<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\Transaction;
use App\Core\Domain\Entity\TransactionCategory;
use App\Core\Domain\Enum\CategoryType;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ITransactionRepository
{
    /** @return LengthAwarePaginator<Transaction> */
    public function findAll(string $userId, ?string $search, ?string $categoryId, ?CategoryType $type, ?Carbon $startDate, ?Carbon $endDate, int $perPage): LengthAwarePaginator;
    public function create(string $userId, string $categoryId, string $title, float $amount, Carbon $dateTime): Transaction;
    public function update(string $userId, string $id, string $categoryId, string $title, float $amount, Carbon $dateTime): Transaction;
    public function delete(string $userId, string $id): void;
    public function getSummary(string $userId, ?Carbon $startDate, ?Carbon $endDate, ?string $categoryId = null, ?string $search = null): array;
}

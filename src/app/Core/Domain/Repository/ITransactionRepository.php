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
    public function findAll(?string $search, ?string $categoryId, ?TransactionCategoryType $type, ?Carbon $startDate, ?Carbon $endDate, int $perPage = 15): LengthAwarePaginator;
    public function create(string $categoryId, string $title, float $amount, Carbon $dateTime): Transaction;
}

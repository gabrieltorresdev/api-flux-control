<?php

namespace App\Persistence\Eloquent\Repository;

use App\Core\Domain\Entity\Transaction;
use App\Core\Domain\Entity\TransactionCategory;
use App\Core\Domain\Enum\TransactionType;
use App\Core\Domain\Repository\ITransactionRepository;
use App\Mapper\TransactionMapper;
use App\Persistence\Eloquent\Model\TransactionModel as Model;
use Carbon\Carbon;

readonly class TransactionRepository implements ITransactionRepository
{
    public function __construct(private Model $model)
    {}

    public function findAll(?TransactionCategory $category, ?Carbon $startDate, ?Carbon $endDate, ?TransactionType $type): array
    {
        return $this->model::query()
            ->with('category')
            ->when($type, function ($query) use ($type) {
                $query->where('type', '=', $type->value);
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', '=', $category->id);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            })
            ->get()
            ->map(fn ($transaction) => TransactionMapper::fromEloquent($transaction))
            ->toArray();
    }
}

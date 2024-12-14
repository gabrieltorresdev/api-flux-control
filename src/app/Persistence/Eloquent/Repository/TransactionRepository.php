<?php

namespace App\Persistence\Eloquent\Repository;

use App\Core\Domain\Entity\Transaction;
use App\Core\Domain\Enum\TransactionCategoryType;
use App\Core\Domain\Repository\ITransactionRepository;
use App\Mapper\TransactionMapper;
use App\Persistence\Eloquent\Model\TransactionModel as Model;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class TransactionRepository implements ITransactionRepository
{
    public function __construct(private Model $model)
    {}

    public function findAll(
        ?string $search,
        ?string $categoryId,
        ?TransactionCategoryType $type,
        ?Carbon $startDate,
        ?Carbon $endDate,
        int $perPage
    ): LengthAwarePaginator
    {
        return $this->model::query()
            ->with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', '=', $categoryId);
            })
            ->when($type, function ($query) use ($type) {
                $query->whereRelation('category', 'type', '=', $type);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date_time', [$startDate, $endDate]);
            })
            ->paginate(min($perPage, 100))
            ->through(fn ($transaction) => TransactionMapper::fromEloquent($transaction));
    }


    public function create(string $categoryId, string $title, float $amount, Carbon $dateTime): Transaction
    {
        $result = $this->model::query()
            ->create([
                'title' => $title,
                'amount' => $amount,
                'date_time' => $dateTime,
                'category_id' => $categoryId,
            ])
            ->load('category');

        return TransactionMapper::fromEloquent($result);
    }
}

<?php

namespace App\Persistence\Eloquent\Repository;

use App\Core\Domain\Entity\TransactionCategory;
use App\Core\Domain\Enum\TransactionCategoryType;
use App\Core\Domain\Repository\ITransactionCategoryRepository;
use App\Mapper\TransactionCategoryMapper;
use App\Persistence\Eloquent\Model\TransactionCategoryModel as Model;

readonly class TransactionCategoryRepository implements ITransactionCategoryRepository
{
    public function __construct(private Model $model)
    {}

    public function create(string $name, TransactionCategoryType $type): TransactionCategory
    {
        $result = $this->model::query()->create(compact(['name', 'type']));

        return TransactionCategoryMapper::fromEloquent($result);
    }
}

<?php

namespace App\Mapper;

use App\Core\Domain\Entity\TransactionCategory as Entity;
use App\Persistence\Eloquent\Model\TransactionCategoryModel as Model;

class TransactionCategoryMapper
{
    public static function fromArray(array|object $dados): Entity
    {
        return self::fromEloquent(new Model($dados));
    }

    public static function fromEloquent(Model $model): Entity
    {
        return new Entity(
            id: $model->id,
            name: $model->name,
            type: $model->type
        );
    }
}

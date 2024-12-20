<?php

namespace App\Mapper;

use App\Core\Domain\Entity\TransactionCategory as Entity;
use App\Persistence\Eloquent\Model\TransactionCategoryModel as Model;

class TransactionCategoryMapper implements Mapper
{
    public static function fromArray(array|object $data): Entity
    {
        return self::fromEloquent(new Model($data));
    }

    public static function fromEloquent(Model $model): Entity
    {
        return new Entity(
            id: $model->id,
            name: $model->name,
            type: $model->type,
            is_default: $model->is_default
        );
    }
}

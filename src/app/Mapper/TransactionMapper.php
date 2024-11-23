<?php

namespace App\Mapper;

use App\Core\Domain\Entity\Transaction as Entity;
use App\Persistence\Eloquent\Model\TransactionModel as Model;

class TransactionMapper implements Mapper
{
    public static function fromArray(array|object $data): Entity
    {
        return self::fromEloquent(new Model($data));
    }

    public static function fromEloquent(Model $model): Entity
    {
        $entity =  new Entity(
            id: $model->id,
            type: $model->type,
            amount: $model->amount,
            date: $model->date,
            description: $model->description
        );

        if ($model->relationLoaded('category')) {
            $entity->setCategory(TransactionCategoryMapper::fromEloquent($model->category));
        }

        return $entity;
    }
}

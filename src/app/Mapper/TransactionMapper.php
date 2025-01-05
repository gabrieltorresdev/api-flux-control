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
            title: $model->title,
            amount: $model->amount,
            dateTime: $model->date_time,
        );

        if ($model->relationLoaded('category')) {
            $entity->setCategory(CategoryMapper::fromEloquent($model->category));
        }

        if ($model->relationLoaded('user')) {
            $entity->setUser(UserMapper::fromEloquent($model->user));
        }

        return $entity;
    }
}

<?php

namespace App\Mapper;

use App\Core\Domain\Entity\User as Entity;
use App\Persistence\Eloquent\Model\UserModel as Model;

class UserMapper
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
            email: $model->email
        );
    }
}
